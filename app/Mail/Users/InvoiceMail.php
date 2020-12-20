<?php

namespace App\Mail\Users;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code, $data, $payment, $filename, $instruction, $total_voucher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $data, $payment, $filename, $instruction, $total_voucher)
    {
        $this->code = $code;
        $this->data = $data;
        $this->payment = $payment;
        $this->filename = $filename;
        $this->instruction = $instruction;
        $this->total_voucher = $total_voucher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $payment = $this->payment;
        $code = $this->code;
        $total_voucher = $this->total_voucher;

        if ($data->isLunas == false) {
            $subject = 'Menunggu Pembayaran ' . strtoupper(str_replace('_', ' ', $payment['type'])) .
                ' #' . $code;
        } else {
            $subject = 'Checkout Pesanan dengan ID Pembayaran #' . $code . ' Berhasil Dikonfirmasi pada ' .
                Carbon::parse($data->created_at)->formatLocalized('%d %B %Y – %H:%M');
        }

        if (!is_null($this->instruction)) {
            $this->attach(public_path('storage/users/invoice/' . $data->user_id . '/' . $this->instruction));
        }

        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))->subject($subject)
            ->view('emails.users.invoice', compact('code', 'data', 'payment', 'total_voucher'))
            ->attach(public_path('storage/users/invoice/' . $data->user_id . '/' . $this->filename));
    }
}
