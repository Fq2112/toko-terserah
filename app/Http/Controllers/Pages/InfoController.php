<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InfoController extends Controller
{
    public function tentang()
    {
        return view('pages.info.tentang-kami');
    }

    public function kontak()
    {
        return view('pages.info.kontak');
    }

    public function kirimKontak(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'subject' => 'required|string|min:3',
            'topic' => 'required|string',
            'message' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'topic' => $request->topic,
            'bodymessage' => $request->message
        );

        Kontak::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => preg_replace("![^a-z0-9+]+!i", "", $data['phone']),
            'subject' => $data['subject'],
            'topic' => $data['topic'],
            'message' => $data['bodymessage']
        ]);

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email'], $data['phone'] != "" ? $data['name'] . ' (' . $data['phone'] . ')' : $data['name']);
            $message->to(env('MAIL_USERNAME'));
            $message->subject($data['topic'] . ': ' . $data['subject']);
        });

        return back()->with('contact', 'Terima kasih telah meninggalkan kami pesan! Karena setiap komentar atau kritik yang Anda berikan, akan membuat kami menjadi perusahaan yang lebih baik.');
    }

    public function syaratKetentuan()
    {
        return view('pages.info.syarat-ketentuan');
    }

    public function kebijakanPrivasi()
    {
        return view('pages.info.kebijakan-privasi');
    }
}
