<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Users\InvoiceMail;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
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
        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Set your Merchant Server Key
        Config::$isProduction = false; // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
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
        app()->setLocale($request->lang);

        $user = User::find($request->user_id);
        $split_name = explode(" ", $user->name);
        $address = Alamat::where('user_id', $user->id)->where('isUtama', true)->first();
        $main_address = $address != "" ? $address->alamat . ' - ' . $address->kode_pos . ' (' . $address->getOccupancy->name . ').' : null;
        $shipping = Alamat::find($request->shipping_id);
        $split_shipping_name = explode(" ", $shipping->nama);
        $billing = Alamat::find($request->billing_id);
        $split_bill_name = explode(" ", $billing->nama);

        $carts = Keranjang::whereIn('id', explode(',', $request->cart_ids))
            ->orderByRaw('FIELD (id, ' . $request->cart_ids . ') ASC')->get();

        $arr_items = [];
        foreach ($carts as $i => $cart) {
            $arr_items[$i] = [
                'id' => strtoupper($cart->getProduk->kode_barang),
                'price' => ceil($cart->getProduk->is_diskon == true ?
                    $cart->getProduk->harga_diskon : $cart->getProduk->harga),
                'quantity' => $cart->qty,
                'name' => Str::limit($cart->getProduk->nama, 50),
                'category' => Str::limit($cart->getProduk->getSubkategori->nama, 50)
            ];
        }

        $arr_ship_disc = [];
        if (!is_null($request->discount)) {
            $arr_ship_disc[count($arr_items)] = [
                'id' => 'DISC-' . $request->code,
                'price' => ceil($request->discount_price * -1),
                'quantity' => 1,
                'name' => 'Diskon ' . $request->discount . '%'
            ];
        }

        $arr_ship_disc[!is_null($request->discount) ? count($arr_items) + 1 : count($arr_items)] = [
            'id' => 'SHIP-' . $request->code,
            'price' => ceil($request->ongkir),
            'quantity' => 1,
            'name' => 'Ongkir'
        ];

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
            'item_details' => array_merge($arr_items, $arr_ship_disc),
        ]);
    }

    public function unfinishCallback(Request $request)
    {
        app()->setLocale($request->lang);

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
            'kurir_id' => $request->kurir_id,
            'ongkir' => $request->ongkir,
            'durasi_pengiriman' => $request->delivery_duration,
            'berat_barang' => $request->weight,
            'total_harga' => $request->total,
            'note' => $request->note,
            'promo_code' => $request->promo_code,
            'is_discount' => !is_null($request->discount) ? 1 : 0,
            'discount' => $request->discount,
        ]);

        foreach ($carts as $cart) {
            $cart->update(['isCheckOut' => true]);
        }

        $this->invoiceMail('unfinish', $code, $user, $request->pdf_url, $data_tr);

        return count($carts) . ' produk pesanan Anda dengan ID Pembayaran #' . $code . ' berhasil di checkout! Kami akan langsung mengirimkan pesanan Anda sesaat setelah Anda menyelesaikan pembayarannya, terima kasih banyak dan Anda akan dialihkan ke halaman Dashboard [Riwayat Pemesanan] :)';
    }

    public function finishCallback(Request $request)
    {
        app()->setLocale($request->lang);
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

                    Pesanan::firstOrCreate([
                        'user_id' => $user->id,
                        'keranjang_ids' => $carts->pluck('id'),
                        'pengiriman_id' => $request->pengiriman_id,
                        'penagihan_id' => $request->penagihan_id,
                        'uni_code' => $code,
                        'kurir_id' => $request->kurir_id,
                        'ongkir' => $request->ongkir,
                        'durasi_pengiriman' => $request->delivery_duration,
                        'berat_barang' => $request->weight,
                        'total_harga' => $data_tr['gross_amount'],
                        'note' => $request->note,
                        'promo_code' => $request->promo_code,
                        'is_discount' => !is_null($request->discount) ? 1 : 0,
                        'discount' => $request->discount,
                        'isLunas' => true,
                    ]);

                    foreach ($carts as $cart) {
                        $cart->update(['isCheckOut' => true]);
                    }
                    $this->invoiceMail('finish', $code, $user, $request->pdf_url, $data_tr);

                    return count($carts) . ' produk pesanan Anda dengan ID Pembayaran #' . $code . ' berhasil dikonfirmasi! Tetap awasi status pesanan Anda pada halaman Dashboard.';
                }
            }

        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function notificationCallback()
    {
        $notif = new Notification();
        $data_tr = collect(Transaction::status($notif->transaction_id))->toArray();

        try {
            if (!array_key_exists('fraud_status', $data_tr) ||
                (array_key_exists('fraud_status', $data_tr) && $data_tr['fraud_status'] == 'accept')) {

                if ($data_tr['payment_type'] != 'credit_card' &&
                    ($data_tr['transaction_status'] == 'capture' || $data_tr['transaction_status'] == 'settlement')) {

                    $pesanan = Pesanan::where('uni_code', $notif->order_id)->first();
                    $user = User::find($pesanan->user_id);

                    $pesanan->update(['isLunas' => true]);
                    $this->invoiceMail('finish', $notif->order_id, $user, null, $data_tr);

                    return count($pesanan->cart_ids) . ' produk pesanan Anda dengan ID Pembayaran #' . $notif->order_id . ' berhasil dikonfirmasi! Tetap awasi status pesanan Anda pada halaman Dashboard.';
                }
            }

        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    private function invoiceMail($status, $code, $user, $pdf_url, $data_tr)
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
            $account = $data_tr['bill_key'];

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

        Mail::to($user->email)->send(new InvoiceMail($code, $data, $payment, $filename, $instruction));
    }
}
