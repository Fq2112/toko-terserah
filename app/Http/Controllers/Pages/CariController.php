<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Support\Facades\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $q->whereBetween(DB::raw("IF(is_diskon=0, harga, harga_diskon)"), [strrev($from), strrev($to)]);
        })->when($kat, function ($q) use ($kat) {
            $q->whereHas('getSubkategori', function ($q) use ($kat) {
                $q->whereIn('id', explode(',', $kat));
            });
        })->when($sort, function ($q) use ($sort) {
            if ($sort == 'popularitas') {
                $q->withCount('getKeranjang')->orderByDesc('get_keranjang_count');
            } elseif ($sort == 'rating') {
                $q->withCount(['getUlasan as average_rating' => function ($q) {
                    $q->select(DB::raw('coalesce(avg(bintang),0)'));
                }])->orderByDesc('average_rating');
            } elseif ($sort == 'harga-asc') {
                $q->orderBy(DB::raw("IF(is_diskon=0, harga, harga_diskon)"));
            } elseif ($sort == 'harga-desc') {
                $q->orderByDesc(DB::raw("IF(is_diskon=0, harga, harga_diskon)"));
            } else {
                $q->orderBy('nama');
            }
        })->orderBy('nama')->paginate(12)->toArray();

        foreach ($data['data'] as $i => $row) {
            $ulasan = Ulasan::where('produk_id', $row['id'])->get();
            $data['data'][$i] = array_merge($data['data'][$i], [
                'dir_img' => asset('storage/produk/thumb/' . $row['gambar']),
                'route_detail' => route('produk', ['produk' => $row['permalink']]),
                'rating' => count($ulasan) > 0 ? $ulasan->sum('bintang') / count($ulasan) : 0,
                'stars' => count($ulasan) > 0 ? Rating::stars($ulasan->avg('bintang')) : Rating::stars(0),
                'cek_cart' => route('produk.cek.cart', ['produk' => $row['permalink']]),
                'add_cart' => route('produk.add.cart', ['produk' => $row['permalink']]),
                'cek_wishlist' => route('produk.cek.wishlist', ['produk' => $row['permalink']]),
                'add_wishlist' => route('produk.add.wishlist', ['produk' => $row['permalink']]),
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
}
