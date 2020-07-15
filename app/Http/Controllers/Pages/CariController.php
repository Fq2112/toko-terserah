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
    public function cariNamaProduk(Request $request)
    {
        $kat = $request->kat;
        $x = 0;
        $y = 0;

        $sub = SubKategori::where('nama', 'LIKE', '%' . $request->q . '%')->when($kat, function ($q) use ($kat) {
            $q->whereHas('getKategori', function ($q) use ($kat) {
                if ($kat != 'semua') {
                    $q->where('permalink', $kat);
                }
            });
        })->orderBy('nama')->get();

        $cluster = Produk::where('nama', 'LIKE', '%' . $request->q . '%')->when($kat, function ($q) use ($kat) {
            $q->whereHas('getSubkategori', function ($q) use ($kat) {
                $q->whereHas('getKategori', function ($q) use ($kat) {
                    if ($kat != 'semua') {
                        $q->where('permalink', $kat);
                    }
                });
            });
        })->orderBy('nama')->get();

        $data = collect($sub)->merge($cluster);
        foreach ($data as $row) {
            $row->label = $row->nama;
            $row->q = $row->permalink;
        }

        return $data;
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
