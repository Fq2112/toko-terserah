<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\QnA;
use App\Models\Ulasan;
use App\Support\Facades\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function beranda()
    {
        $kategori = Kategori::orderBy('nama')->get();
        $banner = Produk::where('stock', '>', 0)->where('is_banner', true)->orderByDesc('id')->get();

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
        $ulasan = Ulasan::where('produk_id', $produk->id)->orderByDesc('id')->get();
        $qna = QnA::where('produk_id', $produk->id)->where('user_id', '!=', Auth::id())->orderByDesc('id')->get();
        $qna_ku = QnA::where('produk_id', $produk->id)->where('user_id', Auth::id())->orderByDesc('id')->get();
        $stars = Rating::stars($ulasan->avg('bintang'));

        $cek_wishlist = Favorit::where('produk_id', $produk->id)->where('user_id', Auth::id())->first();
        $cek_ulasan = Ulasan::where('produk_id', $produk->id)->where('user_id', Auth::id())->first();

        $related = Produk::where('id', '!=', $produk->id)->whereHas('getSubkategori', function ($q) use ($produk) {
            $q->where('id', $produk->sub_kategori_id);
        })->orderBy('nama')->take(8)->get();

        return view('pages.main.detail', compact('produk', 'ulasan', 'qna', 'qna_ku', 'stars',
            'cek_wishlist', 'cek_ulasan', 'related'));
    }

    public function galeriProduk(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();

        return [
            'galeri' => $produk->galeri,
            'thumb' => asset('storage/produk/thumb/' . $produk->gambar)
        ];
    }

    public function cekWishlist(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();
        $favorit = Favorit::where('user_id', Auth::id())->where('produk_id', $produk->id)->first();

        if ($favorit) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tersebut telah ditambahkan ke dalam wishlist Anda sebelumnya!',
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
        $cek = Keranjang::where('user_id', Auth::id())->where('produk_id', $produk->id)->where('isCheckOut', false)->first();

        if ($cek) {
            $cek->update([
                'qty' => $cek->qty + $request->qty,
                'berat' => ($cek->qty + $request->qty) * $produk->berat,
                'total' => ($cek->qty + $request->qty) * $harga,
            ]);

            $produk->update(['stock' => $produk->stock - $request->qty]);

            return back()->with('update', 'Kuantitas produk [' . $produk->nama . '] dari cart Anda berhasil diperbarui!');

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

        return back()->with('delete', 'Produk [' . $cart->getProduk->nama . '] berhasil dihapuskan dari cart Anda!');
    }

    public function submitUlasan(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();

        if (!is_null($request->id)) {
            $ulasan = Ulasan::find(decrypt($request->id));

            if ($request->hasFile('gambar')) {
                $this->validate($request, ['gambar' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
                $name = $request->file('gambar')->getClientOriginalName();
                if ($ulasan->gambar != '') {
                    Storage::delete('public/produk/ulasan/' . $ulasan->gambar);
                }

                if ($request->file('gambar')->isValid()) {
                    $request->gambar->storeAs('public/produk/ulasan', $name);
                }

            } else {
                $name = $ulasan->gambar;
            }

            $ulasan->update([
                'deskripsi' => $request->deskripsi,
                'gambar' => $name,
                'bintang' => $request->rating,
            ]);

            return back()->with('update', 'Ulasan untuk produk [' . $produk->nama . '] berhasil diperbarui!');

        } else {
            if ($request->hasFile('gambar')) {
                $this->validate($request, ['gambar' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
                $name = $request->file('gambar')->getClientOriginalName();
                if ($request->file('gambar')->isValid()) {
                    $request->gambar->storeAs('public/produk/ulasan', $name);
                }

            } else {
                $name = null;
            }

            Ulasan::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
                'deskripsi' => $request->deskripsi,
                'gambar' => $name,
                'bintang' => $request->rating,
            ]);

            return back()->with('add', 'Ulasan untuk produk [' . $produk->nama . '] berhasil dikirimkan!');
        }
    }

    public function submitQnA(Request $request)
    {
        $produk = Produk::where('permalink', $request->produk)->first();
        QnA::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'tanya' => $request->tanya,
        ]);

        return back()->with('add', 'Pertanyaan untuk produk [' . $produk->nama . '] berhasil dikirimkan!');
    }
}
