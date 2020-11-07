<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'application/json',
                'key' => env('RajaOngkir_KEY')
            ],
            'defaults' => [
                'exceptions' => false
            ]
        ]);
    }

    public function get(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $status = $request->status;
            $pesanan = Pesanan::where('user_id', $user->id)->when($status, function ($q) use ($status) {
                if ($status == 'belum_bayar') {
                    $q->where('isLunas', false)->whereNull('tgl_pengiriman')->whereNull('tgl_diterima');
                } elseif ($status == 'dikemas_diambil') {
                    $q->where('isLunas', true)->whereNull('tgl_pengiriman')->whereNull('tgl_diterima');
                } elseif ($status == 'dikirim') {
                    $q->where('isLunas', true)->whereNotNull('tgl_pengiriman')->whereNull('tgl_diterima');
                } elseif ($status == 'selesai') {
                    $q->where('isLunas', true)->whereNotNull('tgl_diterima');
                }
            })->orderByDesc('id')->get();
            $result=[];

            foreach ($pesanan as $i => $row) {
                $cart = Keranjang::whereIn('id', $row->keranjang_ids)->where('isCheckout', true)->orderByDesc('id')->first();

                $recent_track = null;
                if ($row->isAmbil == false && $row->is_kurir_terserah == false && ($status == 'dikirim' || $status == 'selesai')) {
                    $response = $this->client->post(env('RajaOngkir_URL') . '/waybill', [
                        'form_params' => [
                            'waybill' => $row->resi,
                            'courier' => $row->kode_kurir
                        ]
                    ])->getBody()->getContents();
                    $response = json_decode($response, true);
                    if ($response['rajaongkir']['status']['code'] == 200) {
                        if ($row->kode_kurir != 'pos') {
                            $i = count($response['rajaongkir']['result']['manifest']);
                            $recent_track = $response['rajaongkir']['result']['manifest'][$i ? $i - 1 : 0];
                        } else {
                            $recent_track = $response['rajaongkir']['result']['manifest'][0];
                        }
                    }
                }

                $row->total_produk = count($row->keranjang_ids) - 1;

                $row->recent_produk = !is_null($cart) ? $cart->getProduk: [];
                $row->recent_track = $recent_track;

                if(!is_null($cart)){
                    $result[]=$row;
                }
            }

            $result2=[];
            $limit=99999;

            for($i=0;$i<($limit<=count($result) ?$limit : count($result)) ; $i++){
                $result2[]=$result[$i];
            }


            return response()->json([
                'error' => false,
                'data' => $result2,
                'count_cart' => Keranjang::where('user_id', $user->id)->where('isCheckout', 0)->count(),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ],
                'count_cart' => 0,
            ]);
        }
    }

    public function detail(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $pesanan = Pesanan::where('uni_code', $request->code)->whereHas('getPengiriman')->first();
            $carts = Keranjang::query()->whereIn('id', $pesanan->keranjang_ids)->whereHas('getProduk')->orderByDesc('id')->get();
            if (strpos($pesanan->durasi_pengiriman, 'HARI') !== false) {
                $unit = '';
            } elseif (strpos($pesanan->durasi_pengiriman, 'JAM') !== false) {
                $unit = '';
            } else {
                $unit = ' hari';
            }

            if (strpos($pesanan->durasi_pengiriman, '+') !== false) {
                $str_etd = '&ge; ' . str_replace('+', '', $pesanan->durasi_pengiriman) . $unit;
            } else {
                if ($pesanan->durasi_pengiriman == '1-1') {
                    $str_etd = '&le; 1' . $unit;
                } else {
                    $str_etd = str_replace('-', ' – ', $pesanan->durasi_pengiriman) . $unit;
                }
            }

            if (is_null($pesanan->tgl_diterima)) {
                if (is_null($pesanan->tgl_pengiriman)) {
                    if ($pesanan->isLunas == false) {
                        $status = 'MENUNGGU PEMBAYARAN';
                    } else {
                        $status = $pesanan->isAmbil == false ? 'SEDANG DIKEMAS' : 'SIAP DIAMBIL';
                    }
                } else {
                    $status = 'DALAM PENGIRIMAN';
                }
            } else {
                $status = 'PESANAN SELESAI';
            }

            $recent_track = null;
            $full_track = [];
            if (
                $pesanan->isAmbil == false && $pesanan->is_kurir_terserah == false &&
                ($status == 'DALAM PENGIRIMAN' || $status == 'PESANAN SELESAI')
            ) {
                $response = $this->client->post(env('RajaOngkir_URL') . '/waybill', [
                    'form_params' => [
                        'waybill' => $pesanan->resi,
                        'courier' => $pesanan->kode_kurir
                    ]
                ])->getBody()->getContents();
                $response = json_decode($response, true);;
                //                dd(krsort($response['rajaongkir']['result']['manifest']));
                if ($response['rajaongkir']['status']['code'] == 200) {
                    if ($pesanan->kode_kurir != 'pos') {
                        $i = count($response['rajaongkir']['result']['manifest']);
                        $recent_track = $response['rajaongkir']['result']['manifest'][$i ? $i - 1 : 0];
                        $full_track = array_reverse($response['rajaongkir']['result']['manifest']);
                    } else {
                        $recent_track = $response['rajaongkir']['result']['manifest'][0];
                        $full_track = $response['rajaongkir']['result']['manifest'];
                    }
                }
            }
            $array_carts = [];
            $array_produk = [];
            foreach ($carts as $cart) {
                $cart->produk = $cart->getProduk;
                array_push($array_carts, $cart);
                array_push($array_produk, $cart->getProduk->id);
            }
            $pesanan->alamat_pengiriman = Alamat::find($pesanan->pengiriman_id);
            $pesanan->alamat_penagihan = Alamat::find($pesanan->penagihan_id);
            $pesanan->str_etd = $str_etd;
            $pesanan->carts = $array_carts;
            $pesanan->subtotal = $carts->sum('total');
            $pesanan->recent_track = $recent_track;
            $pesanan->full_track = $full_track;
            $pesanan->file_invoice = asset('storage/users/invoice/' . $pesanan->user_id . '/' . $pesanan->uni_code . '.pdf');
            $pesanan->status = $status;
            $pesanan->produk_ids = $array_produk;

            return response()->json([
                'error' => false,
                'data' => $pesanan
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

    public function invoice(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $pesanan = Pesanan::where('uni_code', $request->code)->first();
            $file = asset('storage/users/invoice/' . $pesanan->user_id . '/' . $pesanan->uni_code . '.pdf');

            return view('pages.webviews.invoice', compact('file'));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function received(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $pesanan = Pesanan::where('uni_code', $request->code)->first();
            $pesanan->update(['tgl_diterima' => now()]);

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Penerimaan paket pesanan [' . $pesanan->uni_code . '] Anda berhasil dikonfirmasi!'
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

    public function reorder(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $pesanan = Pesanan::where('uni_code', $request->code)->first();
            $carts = Keranjang::whereIn('id', $pesanan->keranjang_ids)->get();

            foreach ($carts as $cart) {
                $produk = $cart->getProduk;
                if ($produk->isGrosir == true) {
                    $harga = $produk->isDiskonGrosir == true ? $produk->harga_diskon_grosir : $produk->harga_grosir;
                    $min_qty = $produk->min_qty;
                } else {
                    $harga = $produk->is_diskon == true ? $produk->harga_diskon : $produk->harga;
                    $min_qty = 1;
                }
                $cek = Keranjang::where('user_id', $user->id)->where('produk_id', $produk->id)->where('isCheckOut', false)->first();

                if ($produk->stock > 0) {
                    if ($cek) {
                        $cek->update([
                            'qty' => $cek->qty + $min_qty,
                            'berat' => ($cek->qty + $min_qty) * $produk->berat,
                            'total' => ($cek->qty + $min_qty) * $harga,
                        ]);
                    } else {
                        Keranjang::create([
                            'user_id' => $user->id,
                            'produk_id' => $produk->id,
                            'qty' => $min_qty,
                            'berat' => $produk->berat,
                            'total' => $min_qty * $harga,
                        ]);
                    }

                    $produk->update(['stock' => $produk->stock - $min_qty]);
                }
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Semua produk yang masih tersedia dan ada di pesanan [' . $pesanan->uni_code . '] berhasil ditambahkan ke cart Anda! Apakah Anda ingin checkout sekarang?'
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
}
