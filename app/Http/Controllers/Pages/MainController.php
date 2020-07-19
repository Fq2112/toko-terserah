<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function beranda()
    {
        $kategori = Kategori::orderBy('nama')->get();
        $banner = Produk::where('stock', '>', 0)->where('is_banner', true)->orderByDesc('id')->take(3)->get();

        $top5 = Produk::where('stock', '>', 0)->withCount(['getUlasan as average_rating' => function ($q) {
            $q->select(DB::raw('coalesce(avg(bintang),0)'));
        }])->orderByDesc('average_rating')->take(5)->get();

        $cek = Produk::where('stock', '>', 0)->where('is_diskon', true)->inRandomOrder()->first();
        $flash = !is_null($cek) ? $cek : Produk::where('stock', '>', 0)->inRandomOrder()->first();

        $terbaru = Produk::where('stock', '>', 0)->orderByDesc('id')->take(10)->get();
        $terlaris = Produk::where('stock', '>', 0)
            ->withCount('getKeranjang')->orderByDesc('get_keranjang_count')->take(10)->get();
        $unggulan = Produk::where('stock', '>', 0)
            ->withCount(['getUlasan as average_rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg(bintang),0)'));
            }])->orderByDesc('average_rating')->take(10)->get();

        return view('pages.main.beranda', compact('kategori', 'banner', 'top5', 'flash',
            'terbaru', 'terlaris', 'unggulan'));
    }

    public function produk(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();

        return view('pages.main.detail', compact('produk'));
    }

    public function cekWishlist(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();
        $favorit = Favorit::where('user_id', Auth::id())->where('produk_id', $produk->id)->first();

        if ($favorit) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tersebut telah Anda tambahkan ke dalam wishlist Anda sebelumnya!',
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => null,
            ], 200);
        }
    }

    public function addWishlist(Request $request)
    {
        $total_wishlist = count(Auth::user()->getWishlist);
        $produk = Produk::where('permalink', $request->produk)->first();
        Favorit::firstOrCreate([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
        ]);

        return response()->json([
            'status' => true,
            'total' => $total_wishlist > 0 ? $total_wishlist + 1 : 1,
            'message' => 'Produk [' . $produk->nama . '] berhasil ditambahkan ke wishlist Anda!',
        ], 200);
    }

    public function cekCart(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();
        if ($produk->stock > 0) {
            return response()->json([
                'status' => true,
                'stock' => $produk->stock,
                'message' => 'Produk [' . $produk->nama . '] tersedia.'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'stock' => $produk->stock,
                'message' => 'Produk [' . $produk->nama . '] telah habis terjual!'
            ], 200);
        }
    }

    public function addCart(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();
        $harga = $produk->is_diskon == true ? $produk->harga_diskon : $produk->harga;
        $cek = Keranjang::where('user_id', Auth::id())->where('produk_id', $produk->id)->first();

        if ($cek) {
            $cek->update([
                'qty' => $cek->qty + $request->qty,
                'berat' => ($cek->qty + $request->qty) * $produk->berat,
                'total' => ($cek->qty + $request->qty) * $harga,
            ]);

            $produk->update(['stock' => $produk->stock - $request->qty]);

            return back()->with('delete', 'Kuantitas produk [' . $produk->nama . '] dari cart Anda berhasil diperbarui!');

        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
                'qty' => $request->qty,
                'berat' => $request->qty * $produk->berat,
                'total' => $request->qty * $harga,
            ]);

            $produk->update(['stock' => $produk->stock - $request->qty]);

            return back()->with('add', 'Produk [' . $produk->nama . '] berhasil ditambahkan ke cart Anda!');
        }
    }

    public function updateCart(Request $request)
    {
        $cart = Keranjang::find(decrypt($request->id));
        $harga = $cart->getProduk->is_diskon == true ? $cart->getProduk->harga_diskon : $cart->getProduk->harga;
        $selish = $request->qty - $request->qty_lama;

        $cart->update([
            'qty' => $request->qty,
            'berat' => $request->qty * $cart->getProduk->berat,
            'total' => $request->qty * $harga,
        ]);

        $cart->getProduk->update(['stock' => $cart->getProduk->stock - $selish]);

        return back()->with('update', 'Kuantitas produk [' . $cart->getProduk->nama . '] dari cart Anda berhasil diperbarui!');
    }

    public function deleteCart(Request $request)
    {
        $cart = Keranjang::find(decrypt($request->id));
        $cart->getProduk->update(['stock' => $cart->getProduk->stock + $cart->qty]);
        $cart->delete();

        return back()->with('delete', 'Produk [' . $cart->getProduk->nama . '] Anda berhasil dihapuskan dari cart Anda!');
    }
}
