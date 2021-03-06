<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Users\InvoiceMail;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\PromoCode;
use App\Models\Setting;
use App\Models\VouucherUser;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransController extends Controller
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

    public function snap(Request $request)
    {
        app()->setLocale('id');

        $user = User::find($request->user_id);
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
            'id' => 'PACK-' . $request->code,
            'price' => !is_null($request->packing) ? ceil($request->packing) : 0,
            'quantity' => 1,
            'name' => 'Biaya Packing'
        ];

        if (!is_null($request->discount_price)) {
            $arr_pack_ship_disc[count($arr_items) + 1] = [
                'id' => 'DISC-' . $request->code,
                'price' => ceil($request->discount_price * -1),
                'quantity' => 1,
                'name' => 'Diskon'
            ];
        }

        $arr_pack_ship_disc[!is_null($request->discount_price) ? count($arr_items) + 2 : count($arr_items) + 1] = [
            'id' => 'SHIP-' . $request->code,
            'price' => ceil($request->ongkir),
            'quantity' => 1,
            'name' => 'Ongkir'
        ];

        $keranjang_ids = explode(',', $request->cart_ids);
        foreach ($keranjang_ids as $i => $dt) {
            $keranjang_ids[$i] = "$dt";
        }

        $check = Pesanan::where('uni_code', $request->code)->first();
        if (!$check) {
            Pesanan::firstOrCreate([
                'user_id' => $user->id,
                'keranjang_ids' => $keranjang_ids,
                'pengiriman_id' => $request->pengiriman_id,
                'penagihan_id' => $request->penagihan_id,
                'uni_code' => $request->code,
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

        return Snap::getSnapToken([
            'enabled_payments' => $this->channels,
            'transaction_details' => [
                'order_id' => $request->code,
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
        ]);
    }

    /*public function unfinishCallback(Request $request)
    {
        app()->setLocale('id');

        $data_tr = collect(Transaction::status($request->transaction_id))->toArray();
        $code = $data_tr['order_id'];

        $carts = Keranjang::whereIn('id', explode(',', $request->cart_ids))
            ->orderByRaw('FIELD (id, ' . $request->cart_ids . ') ASC')->get();
        $user = User::find(implode($carts->take(1)->pluck('user_id')->toArray()));

        Pesanan::firstOrCreate([
            'user_id' => $user->id,
            'keranjang_ids' => $carts->pluck('id'),
            'pengiriman_id' => $request->pengiriman_id,
            'penagihan_id' => $request->penagihan_id,
            'uni_code' => $code,
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

        foreach ($carts as $cart) {
            $cart->update(['isCheckOut' => true]);
        }

        $this->invoiceMail('unfinish', $code, $user, $request->pdf_url, $data_tr);

        return $carts->sum('qty') . ' item pesanan Anda dengan ID Pembayaran #' . $code . ' berhasil di checkout! Kami akan langsung mengirimkan pesanan Anda sesaat setelah Anda menyelesaikan pembayarannya, terima kasih banyak dan Anda akan dialihkan ke halaman Dashboard [Riwayat Pemesanan] :)';
    }

    public function finishCallback(Request $request)
    {
        app()->setLocale('id');
        $data_tr = collect(Transaction::status($request->transaction_id))->toArray();
        $code = $data_tr['order_id'];

        try {
            if (!array_key_exists('fraud_status', $data_tr) ||
                (array_key_exists('fraud_status', $data_tr) && $data_tr['fraud_status'] == 'accept')) {

                if ($data_tr['payment_type'] == 'credit_card' &&
                    ($data_tr['transaction_status'] == 'capture' || $data_tr['transaction_status'] == 'settlement')) {

                    $carts = Keranjang::whereIn('id', explode(',', $request->cart_ids))
                        ->orderByRaw('FIELD (id, ' . $request->cart_ids . ') ASC')->get();
                    $user = User::find(implode($carts->take(1)->pluck('user_id')->toArray()));

                    $pesanan = Pesanan::firstOrCreate([
                        'user_id' => $user->id,
                        'keranjang_ids' => $carts->pluck('id'),
                        'pengiriman_id' => $request->pengiriman_id,
                        'penagihan_id' => $request->penagihan_id,
                        'uni_code' => $code,
                        'ongkir' => $request->ongkir != "" ? $request->ongkir : 0,
                        'durasi_pengiriman' => $request->durasi_pengiriman != "" ? $request->durasi_pengiriman : 'N/A',
                        'berat_barang' => $request->weight,
                        'total_harga' => $data_tr['gross_amount'],
                        'note' => $request->note,
                        'promo_code' => $request->promo_code,
                        'is_discount' => !is_null($request->discount_price) ? 1 : 0,
                        'discount' => $request->discount_price,
                        'isLunas' => true,
                        'kode_kurir' => $request->kode_kurir,
                        'nama_kurir' => $request->nama_kurir,
                        'layanan_kurir' => $request->layanan_kurir,
                        'isAmbil' => $request->opsi == 'ambil' ? true : false,
                        'is_kurir_terserah' => $request->opsi == 'terserah' ? true : false,
                    ]);

                    foreach ($carts as $cart) {
                        $cart->update(['isCheckOut' => true]);
                    }
                    $this->invoiceMail('finish', $code, $user, $request->pdf_url, $data_tr);

                    //Todo Create Shipping label

                    $labelname = $pesanan->uni_code . '.pdf';
                    $labelPdf = PDF::loadView('exports.shipping', [
                        'data' => $pesanan,
                    ]);
                    $labelPdf->setPaper('a5', 'potrait');
                    Storage::put('public/users/order/invoice/owner/label/' . $pesanan->uni_code . '/' . $labelname, $labelPdf->output());

                    return $carts->sum('qty') . ' item pesanan Anda dengan ID Pembayaran #' . $code . ' berhasil dikonfirmasi! Tetap awasi status pesanan Anda pada halaman Dashboard.';
                }
            }

        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }*/

    public function notificationCallback()
    {
        $notif = new Notification();
        $data_tr = collect(Transaction::status($notif->transaction_id))->toArray();
        $pesanan = Pesanan::where('uni_code', $notif->order_id)->first();
        $carts = Keranjang::whereIn('id', $pesanan->keranjang_ids)->get();
        $user = User::find($pesanan->user_id);
        $promo = PromoCode::whereRaw('CAST(minim_beli as UNSIGNED) <= ?', [$pesanan->total_harga])
            ->where('start', '<=', now())->where('end', '>=', now()->subDay())->get();

        try {
            if (
                !array_key_exists('fraud_status', $data_tr) ||
                (array_key_exists('fraud_status', $data_tr) && $data_tr['fraud_status'] == 'accept')
            ) {

                if(!is_null($pesanan->promo_code) && $pesanan->is_discount == true) {
                    $voucher = VouucherUser::whereHas('getVoucher', function ($q) use ($pesanan) {
                        $q->where('promo_code', $pesanan->promo_code);
                    })->where('user_id', $user->id)->first();
                } else {
                    $voucher = null;
                }

                if ($data_tr['transaction_status'] == 'pending') {
                    DB::beginTransaction();

                    foreach ($carts as $cart) {
                        $cart->update(['isCheckOut' => true]);
                    }
                    $this->invoiceMail('unfinish', $notif->order_id, $user, null, $data_tr, 0);

                    /* TODO update voucher if pesanan unpaid */
                    if(!is_null($voucher)) {
                        $voucher->update(['is_use' => true, 'used_at' => null]);
                    }

                    DB::commit();
                    return $carts->sum('qty') . ' item pesanan Anda dengan ID Pembayaran #' . $notif->order_id . ' berhasil di checkout! Kami akan langsung mengirimkan pesanan Anda sesaat setelah Anda menyelesaikan pembayarannya, terima kasih banyak dan Anda akan dialihkan ke halaman Dashboard [Riwayat Pemesanan] :)';

                } elseif ($data_tr['transaction_status'] == 'capture' || $data_tr['transaction_status'] == 'settlement') {
                    DB::beginTransaction();

                    foreach ($carts as $cart) {
                        $cart->update(['isCheckOut' => true]);
                    }
                    $pesanan->update(['isLunas' => true]);
                    $this->invoiceMail('finish', $notif->order_id, $user, null, $data_tr, count($promo));

                    /* TODO update voucher if pesanan paid */
                    if(!is_null($voucher)) {
                        $voucher->update(['is_use' => true, 'used_at' => now()]);
                    } else {
                        if(count($promo) > 0) {
                            foreach ($promo as $item) {
                                VouucherUser::query()->create([
                                    'user_id' => $user->id,
                                    'voucher_id' => $item->id,
                                ]);
                            }
                        }
                    }

                    // Todo Create Shipping label
                    $labelname = $pesanan->uni_code . '.pdf';
                    $labelPdf = PDF::loadView('exports.shipping', ['data' => $pesanan]);
                    $labelPdf->setPaper('a5', 'potrait');
                    Storage::put('public/users/order/invoice/owner/label/' . $pesanan->uni_code . '/' . $labelname, $labelPdf->output());

                    DB::commit();
                    return $carts->sum('qty') . ' item pesanan Anda dengan ID Pembayaran #' . $notif->order_id . ' berhasil dikonfirmasi! Tetap awasi status pesanan Anda pada halaman Dashboard.';

                } elseif ($data_tr['transaction_status'] == 'expired') {
                    $check_next_trans = $check_next_trans2 = 0;

                    $carts = Keranjang::whereIn('id', $pesanan->keranjang_ids)
                        ->where('isCheckout', true)
                        ->first();
                    if (is_array($pesanan->keranjang_ids)) {
                        $check_next_trans = Pesanan::where('id', '>', $pesanan->id)
                            ->where('user_id', $user->id)
                            ->where('keranjang_ids', '["' . implode('","', $pesanan->keranjang_ids) . '"]')->count();

                        $check_next_trans2 = Pesanan::where('id', '>', $pesanan->id)
                            ->where('user_id', $user->id)
                            ->where('keranjang_ids', '[' . implode(',', $pesanan->keranjang_ids) . ']')->count();
                    }

                    DB::beginTransaction();

                    if ($carts && ($check_next_trans == 0 && $check_next_trans2 == 0)) {
                        $ker = Keranjang::whereIn('id', $pesanan->keranjang_ids)->get();
                        foreach ($ker as $dt) {
                            $produk = Produk::findOrFail($dt->produk_id);

                            $produk->update([
                                'stock' => $produk->stock + $dt->qty,
                            ]);

                            $dt->delete();
                        }
                    }

                    $pesanan->delete();
                    $this->invoiceMail('expired', $notif->order_id, $user, null, $data_tr, 0);

                    /* TODO update voucher if pesanan expired */
                    if(!is_null($voucher)) {
                        $voucher->update(['is_use' => false, 'used_at' => null]);
                    }

                    DB::commit();

                    return $carts->sum('qty') . ' item pesanan Anda dengan ID Pembayaran #' . $notif->order_id . ' telah dibatalkan!';
                }
            }
        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    private function invoiceMail($status, $code, $user, $pdf_url, $data_tr, $total_voucher)
    {
        $data = Pesanan::where('uni_code', $code)->first();

        if ($data_tr['payment_type'] == 'credit_card') {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['card_type'];
            $account = $data_tr['masked_card'];
        } else if ($data_tr['payment_type'] == 'bank_transfer') {
            $type = $data_tr['payment_type'];

            if (array_key_exists('permata_va_number', $data_tr)) {
                $bank = 'permata';
                $account = $data_tr['permata_va_number'];
            } else {
                $bank = implode((array)$data_tr['va_numbers'][0]->bank);
                $account = implode((array)$data_tr['va_numbers'][0]->va_number);
            }
        } else if ($data_tr['payment_type'] == 'echannel') {
            $type = 'bank_transfer';
            $bank = 'mandiri';
            $account = $data_tr['biller_code'].' / '.$data_tr['bill_key'];
        } else if ($data_tr['payment_type'] == 'cstore') {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['store'];
            $account = $data_tr['payment_code'];
        } else {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['payment_type'];
            $account = null;
        }

        $payment = [
            'type' => $type,
            'bank' => $bank,
            'account' => $account,
        ];

        $filename = $code . '.pdf';
        $check_file = 'public/users/invoice/' . $user->id . '/' . $filename;
        if ($status == 'finish') {
            if (Storage::exists($check_file)) {
                Storage::delete($check_file);
            }
        }

        $pdf = PDF::loadView('exports.invoice', compact('code', 'data', 'payment'));
        Storage::put('public/users/invoice/' . $user->id . '/' . $filename, $pdf->output());

        if (!is_null($pdf_url)) {
            $instruction = $code . '-instruction.pdf';
            Storage::put('public/users/invoice/' . $user->id . '/' . $instruction, file_get_contents($pdf_url));
        } else {
            $instruction = null;
        }

        Mail::to($user->email)->send(new InvoiceMail($status, $code, $data, $payment, $filename, $instruction, $total_voucher));
    }
}
