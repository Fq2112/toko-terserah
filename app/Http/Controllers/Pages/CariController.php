<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\SubKategori;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;

class CariController extends Controller
{
    public function cari(Request $request)
    {
        $q = $request->q;
        $title = !is_null($q) ? ' "' . $q . '" ' : ' ';
        $kategori = Kategori::orderBy('nama')->get();

        return view('pages.main.cari', compact('q', 'title', 'kategori'));
    }

    public function cariData(Request $request)
    {
        return;
    }

    public function cariNamaProduk(Request $request)
    {
        $produk = Produk::where('nama', 'LIKE', '%' . $request->q . '%')->orderBy('nama')->get();

        foreach ($produk as $row) {
            $row->label = $row->nama;
            $row->q = $row->permalink;
        }

        return $produk;
    }

    public function cekPengirimanProduk(Request $request)
    {
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'application/json',
                'key' => env('RajaOngkir_KEY')
            ],
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        try {
            $response = $client->post('https://api.rajaongkir.com/starter/cost', [
                'form_params' => [
                    'origin' => 444,
                    'destination' => $request->destination,
                    'weight' => 2,
                    'courier' => 'jne'
                ]
            ])->getBody()->getContents();

            return json_decode($response, true);

        } catch (ConnectException $e) {
            return response()->json();
        }
    }
}
