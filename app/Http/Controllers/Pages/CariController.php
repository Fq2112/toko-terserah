<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\SubKategori;
use App\Models\Ulasan;
use App\Support\Facades\Rating;
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

        $data = Produk::where('stock', '>', 0)->when($keyword, function ($q) use ($keyword) {
            $q->where('nama', 'LIKE', '%' . $keyword . '%');
        })->when($harga, function ($q) use ($harga) {
            list($to, $from) = explode('-', strrev($harga), 2);
            $q->whereBetween('harga', [strrev($from), strrev($to)]);
        })->when($kat, function ($q) use ($kat) {
            $q->whereHas('getSubkategori', function ($q) use ($kat) {
                $q->whereIn('id', explode(',', $kat));
            });
        })->when($sort, function ($q) use ($sort) {
            if ($sort == 'popularitas') {
                $q->withCount('getKeranjang')->orderByDesc('get_keranjang_count');
            } elseif ($sort == 'harga-asc') {
                $q->orderBy('harga');
            } elseif ($sort == 'harga-desc') {
                $q->orderByDesc('harga');
            } else {
                $q->orderBy('nama');
            }
        })->orderBy('nama')->paginate(12)->toArray();

        foreach ($data['data'] as $i => $row) {
            $ulasan = Ulasan::where('produk_id', $row['id'])->get();
            $data['data'][$i] = array_merge($data['data'][$i], [
                'dir_img' => asset('storage/produk/thumb/' . $row['gambar']),
                'route_detail' => route('produk', ['produk' => $row['permalink']]),
                'disc_price' => $row['is_diskon'] == true ? ceil($row['harga'] - ($row['harga'] * $row['diskon'] / 100)) : 0,
                'rating' => count($ulasan) > 0 ? $ulasan->sum('bintang') / count($ulasan) : 0,
                'stars' => count($ulasan) > 0 ? Rating::stars($ulasan->sum('bintang') / count($ulasan)) : Rating::stars(0)
            ]);
        }

        return $data;
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
