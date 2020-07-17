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
        $kat = $request->kat;
        $title = !is_null($q) ? ' "' . $q . '" ' : ' ';
        $kategori = Kategori::orderBy('nama')->get();

        return view('pages.main.cari', compact('q', 'kat', 'title', 'kategori'));
    }

    public function cariData(Request $request)
    {
        $kat = $request->kat;
        $sort = $request->sort;
        $keyword = $request->q;
        $harga = $request->harga;

        $data = Produk::when($keyword, function ($q) use ($keyword) {
            $q->where('nama', 'LIKE', '%' . $keyword . '%');
        })->when($harga, function ($q) use ($harga) {
            list($to,$from) = explode('-',strrev($harga),2);
            $q->whereBetween('harga', [strrev($from), strrev($to)]);
        })->when($kat, function ($q) use ($kat) {
            $q->whereHas('getSubkategori', function ($q) use ($kat) {
                $q->whereIn('id', explode(',', $kat));
            });
        })->when($sort, function ($q) use ($sort) {
            if($sort == 'harga-asc') {
                $q->orderBy('harga');
            } elseif($sort == 'harga-desc') {
                $q->orderByDesc('harga');
            } else {
                $q->orderBy('nama');
            }
        })->orderBy('nama')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
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
