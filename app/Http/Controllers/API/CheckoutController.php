<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PromoCode;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckoutController extends Controller
{
    public $channels;

    public function __construct()
    {
        $setting = Setting::query()->first();

        Config::$serverKey =  $setting->is_maintenance == true ? env('MIDTRANS_SB_SERVER_KEY') : env('MIDTRANS_SERVER_KEY'); // Set your Merchant Server Key
        Config::$isProduction =  $setting->is_maintenance == true ? false : true; // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isSanitized = true; // Set sanitization on (default)
        Config::$is3ds = true; // Set 3DS transaction for credit card to true

        // Uncomment for append and override notification URL
        // Config::$appendNotifUrl = "https://example.com";
        // Config::$overrideNotifUrl = "https://example.com";

        // Optional, remove this to display all available payment methods
        $this->channels = ["credit_card", "bca_va", "echannel", "bni_va", "permata_va", "other_va", "gopay", "indomaret", "alfamart"];
    }

    public function get_rule()
    {
        try {
            $data = \App\Models\Setting::query()->where('id', '!=', 0)->select('packing','min_transaction','harga_pengiriman')->first();

            return response()->json([
                'error' => false,
                'data' => $data
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ],500);
        }
    }

    public function check($code)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $cek = Pesanan::where('uni_code', $code)->where('user_id', $user->id)->where('isLunas', true)->first();
            if ($cek) {
                $carts = Keranjang::whereIn('id', $cek->keranjang_ids)->count();
                $carts_checkout = Keranjang::whereIn('id', $cek->keranjang_ids)->where('isCheckout', true)->count();
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'condition' => $cek ? ($carts == $carts_checkout ? true : false) : false,
                    'result' => $cek,
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function snap(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            app()->setLocale('id');

            $code = strtoupper(uniqid('PYM') . now()->timestamp);
            $split_name = explode(" ", $user->name);
            $address = Alamat::where('user_id', $user->id)->where('isUtama', true)->first();
            $main_address = $address != "" ? $address->alamat . ' - ' . $address->kode_pos . ' (' . $address->getOccupancy->name . ').' : null;
            $shipping = Alamat::find($request->pengiriman_id);
            $split_shipping_name = explode(" ", $shipping->nama);
            $billing = Alamat::find($request->penagihan_id);
            $split_bill_name = explode(" ", $billing->nama);

            $carts = Keranjang::whereIn('id', explode(',', $request->cart_ids))
                ->orderByRaw('FIELD (id, ' . $request->cart_ids . ') ASC')->get();

            $arr_items = [];
            foreach ($carts as $i => $cart) {
                if ($cart->getProduk->isGrosir == true) {
                    $price = ceil($cart->getProduk->isDiskonGrosir == true ? $cart->getProduk->harga_diskon_grosir : $cart->getProduk->harga_grosir);
                } else {
                    $price = ceil($cart->getProduk->is_diskon == true ? $cart->getProduk->harga_diskon : $cart->getProduk->harga);
                }

                $arr_items[$i] = [
                    'id' => strtoupper($cart->getProduk->kode_barang),
                    'price' => $price,
                    'quantity' => $cart->qty,
                    'name' => Str::limit($cart->getProduk->nama, 50),
                    'category' => Str::limit($cart->getProduk->getSubkategori->nama, 50)
                ];
            }

            $arr_pack_ship_disc = [];

            $arr_pack_ship_disc[count($arr_items)] = [
                'id' => 'PACK-' . $code,
                'price' => !is_null($request->packing) ? ceil($request->packing) : 0,
                'quantity' => 1,
                'name' => 'Biaya Packing'
            ];

            if (!is_null($request->discount_price)) {
                $arr_pack_ship_disc[count($arr_items) + 1] = [
                    'id' => 'DISC-' . $code,
                    'price' => ceil($request->discount_price * -1),
                    'quantity' => 1,
                    'name' => 'Diskon'
                ];
            }

            $arr_pack_ship_disc[!is_null($request->discount_price) ? count($arr_items) + 2 : count($arr_items) + 1] = [
                'id' => 'SHIP-' . $code,
                'price' => ceil($request->ongkir),
                'quantity' => 1,
                'name' => 'Ongkir'
            ];

            $check = Pesanan::where('uni_code', $code)->first();
            if (!$check) {
                Pesanan::firstOrCreate([
                    'user_id' => $user->id,
                    'keranjang_ids' => explode(',', $request->cart_ids),
                    'pengiriman_id' => $request->pengiriman_id,
                    'penagihan_id' => $request->penagihan_id,
                    'uni_code' => $code,
                    'packing_price' => $request->packing != "" ? $request->packing : 0,
                    'ongkir' => $request->ongkir != "" ? $request->ongkir : 0,
                    'durasi_pengiriman' => $request->durasi_pengiriman != "" ? $request->durasi_pengiriman : 'N/A',
                    'berat_barang' => $request->weight,
                    'total_harga' => $request->total,
                    'note' => $request->note,
                    'promo_code' => $request->promo_code,
                    'is_discount' => !is_null($request->discount_price) ? 1 : 0,
                    'discount' => $request->discount_price,
                    'kode_kurir' => $request->kode_kurir,
                    'nama_kurir' => $request->nama_kurir,
                    'layanan_kurir' => $request->layanan_kurir,
                    'isAmbil' => $request->opsi == 'ambil' ? true : false,
                    'is_kurir_terserah' => $request->opsi == 'terserah' ? true : false,
                ]);
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'uni_code' => $code,
                    'snap' => Snap::getSnapToken([
                        'enabled_payments' => $this->channels,
                        'transaction_details' => [
                            'order_id' => $code,
                            'gross_amount' => $request->total,
                        ],
                        'customer_details' => [
                            'first_name' => array_shift($split_name),
                            'last_name' => implode(" ", $split_name),
                            'phone' => $user->getBio->phone,
                            'email' => $user->email,
                            'address' => $main_address,
                            'billing_address' => [
                                'first_name' => array_shift($split_bill_name),
                                'last_name' => implode(" ", $split_bill_name),
                                'address' => $billing->alamat,
                                'city' => $billing->getKecamatan->getKota->getProvinsi->nama . ', ' . $billing->getKecamatan->getKota->nama,
                                'postal_code' => $billing->kode_pos,
                                'phone' => $billing->telp,
                                'country_code' => 'IDN'
                            ],
                            'shipping_address' => [
                                'first_name' => array_shift($split_shipping_name),
                                'last_name' => implode(" ", $split_shipping_name),
                                'address' => $shipping->alamat,
                                'city' => $shipping->getKecamatan->getKota->getProvinsi->nama . ', ' . $shipping->getKecamatan->getKota->nama,
                                'postal_code' => $shipping->kode_pos,
                                'phone' => $shipping->telp,
                                'country_code' => 'IDN'
                            ],
                        ],
                        'item_details' => array_merge($arr_items, $arr_pack_ship_disc),
                    ])
                ]
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function snapWebview(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $setting = Setting::query()->first();
            $data = [
                'snap_token' => $request->snap_token,
                'cart_ids' => $request->cart_ids,
                'pengiriman_id' => $request->pengiriman_id,
                'penagihan_id' => $request->penagihan_id,
                'ongkir' => $request->ongkir,
                'durasi_pengiriman' => $request->durasi_pengiriman,
                'weight' => ceil($request->weight * 1000),
                'total' => $request->total,
                'note' => $request->note,
                'promo_code' => $request->promo_code,
                'discount_price' => $request->discount_price,
                'kode_kurir' => $request->kode_kurir,
                'nama_kurir' => $request->nama_kurir,
                'layanan_kurir' => $request->layanan_kurir,
                'opsi' => $request->opsi,
                'token' => $request->token,
            ];

            return view('pages.webviews.snap-midtrans', compact('setting','data'));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function promo(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $promo = PromoCode::where('promo_code', $request->kode)->first();
            $pesanan = Pesanan::where('promo_code', $request->kode)
                ->where('user_id', $user->id)
                ->get();
            $amount = ceil($request->subtotal);

            if ($promo) {
                $inUsed = false;

                foreach ($pesanan as $t) {
                    $check_keranjang = Keranjang::whereIn('id', $t->keranjang_ids)->first();
                    if ($check_keranjang && $check_keranjang->isCheckOut) {
                        $inUsed = true;
                        break;
                    }
                }
                if ($inUsed) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Anda telah menggunakan kode promo ini!'
                    ], 400);
                } else {
                    if (now() > $promo->end) {
                        return response()->json([
                            'error' => true,
                            'message' => 'Kode promo yang Anda masukkan telah kedaluwarsa.'
                        ], 400);
                    } else {
                        $discount_price = ceil($promo->discount);
                        $subtotal = $amount - $discount_price;
                        $total = ceil($subtotal + $request->ongkir);

                        return response()->json([
                            'error' => false,
                            'data' => [
                                'caption' => $promo->description,
                                'total' => $total,
                                'discount_price' => $discount_price,
                                'str_discount' => '-Rp' . number_format($discount_price, 2, ',', '.'),
                                'str_total' => 'Rp' . number_format($total, 2, ',', '.')
                            ],
                        ], 200);
                    }
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Kode promo yang Anda masukkan tidak ditemukan.'
                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }
}
