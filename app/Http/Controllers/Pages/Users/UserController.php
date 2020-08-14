<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\Mail\Users\InvoiceMail;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Favorit;
use App\Models\OccupancyType;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\PromoCode;
use App\Models\Provinsi;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function wishlist()
    {
        $wishlist = Favorit::where('user_id', Auth::id())->orderByDesc('id')->get();

        return view('pages.main.users.wishlist', compact('wishlist'));
    }

    public function deleteWishlist(Request $request)
    {
        $wishlist = Favorit::find(decrypt($request->id));
        $wishlist->delete();

        return back()->with('delete', 'Produk [' . $wishlist->getProduk->nama . '] berhasil dihapuskan dari wishlist Anda!');
    }

    public function addWishlist(Request $request)
    {
        $cart = Keranjang::find(decrypt($request->cart_id));
        $produk = $cart->getProduk;
        $favorit = Favorit::where('user_id', Auth::id())->where('produk_id', $produk->id)->first();
        if (!$favorit) {
            Favorit::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
            ]);
        }

        $produk->update(['stock' => $produk->stock + $cart->qty]);
        $cart->delete();

        return back()->with('add', 'Produk [' . $produk->nama . '] berhasil ditambahkan ke wishlist Anda!');
    }

    public function massAddWishlist(Request $request)
    {
        $carts = Keranjang::whereIn('id', explode(",", $request->cart_ids))->get();
        foreach ($carts as $cart) {
            $produk = $cart->getProduk;
            $favorit = Favorit::where('user_id', Auth::id())->where('produk_id', $produk->id)->first();
            if (!$favorit) {
                Favorit::create([
                    'user_id' => Auth::id(),
                    'produk_id' => $produk->id,
                ]);
            }

            $produk->update(['stock' => $produk->stock + $cart->qty]);
            $cart->delete();
        }

        return back()->with('add', $carts->sum('qty') . ' produk yang ada di cart berhasil dipindahkan ke wishlist Anda!');
    }

    public function massDeleteWishlist()
    {
        $wishlist = Favorit::where('user_id', Auth::id())->get();
        foreach ($wishlist as $row) {
            $row->delete();
        }

        return back()->with('delete', 'Semua produk berhasil dihapuskan dari wishlist Anda!');
    }

    public function cart()
    {
        $carts = Keranjang::where('user_id', Auth::id())->where('isCheckOut', false)->orderByDesc('id')->get();

        return view('pages.main.users.cart', compact('carts'));
    }

    public function massAddCart()
    {
        $wishlist = Favorit::where('user_id', Auth::id())->get();
        foreach ($wishlist as $row) {
            $produk = $row->getProduk;
            $harga = $produk->is_diskon == true ? $produk->harga_diskon : $produk->harga;
            $cek = Keranjang::where('user_id', Auth::id())->where('produk_id', $produk->id)->where('isCheckOut', false)->first();

            if ($produk->stock > 0) {
                if ($cek) {
                    $cek->update([
                        'qty' => $cek->qty + 1,
                        'berat' => ($cek->qty + 1) * $produk->berat,
                        'total' => ($cek->qty + 1) * $harga,
                    ]);
                } else {
                    Keranjang::create([
                        'user_id' => Auth::id(),
                        'produk_id' => $produk->id,
                        'qty' => 1,
                        'berat' => $produk->berat,
                        'total' => $harga,
                    ]);
                }

                $produk->update(['stock' => $produk->stock - 1]);
            }
        }

        return back()->with('add', 'Semua produk yang masih tersedia dan ada di wishlist berhasil ditambahkan ke cart Anda!');
    }

    public function massDeleteCart(Request $request)
    {
        $carts = Keranjang::whereIn('id', explode(",", $request->cart_ids))->get();
        foreach ($carts as $cart) {
            $cart->getProduk->update(['stock' => $cart->getProduk->stock + $cart->qty]);
            $cart->delete();
        }

        return back()->with('delete', $carts->sum('qty') . ' produk berhasil dihapuskan dari cart Anda!');
    }

    public function cartCheckout(Request $request)
    {
        $user = Auth::user();
        $bio = $user->getBio;
        $addresses = Alamat::where('user_id', $user->id)->orderByDesc('id')->get();
        $provinces = Provinsi::all();
        $occupancies = OccupancyType::all();
        $code = strtoupper(uniqid('PYM') . now()->timestamp);
        $cart_ids = $request->cart_ids;

        $archive = Keranjang::whereIn('id', explode(",", $cart_ids))->where('isCheckOut', false)
            ->orderByRaw('FIELD (id, ' . $cart_ids . ') ASC')->get()->groupBy(function ($q) {
                return Carbon::parse($q->created_at)->formatLocalized('%B %Y');
            });
        $carts = $archive;
        $total_item = Keranjang::whereIn('id', explode(",", $cart_ids))->sum('qty');

        $subtotal = 0;
        $total_weight = 0;

        return view('pages.main.users.checkout', compact('user', 'bio', 'addresses', 'provinces',
            'occupancies', 'code', 'cart_ids', 'carts', 'total_item', 'subtotal', 'total_weight'));
    }

    public function cariPromo(Request $request)
    {
        $promo = PromoCode::where('promo_code', $request->kode)->first();
        $pesanan = Pesanan::where('promo_code', $request->kode)->where('user_id', Auth::id())->first();
        $amount = ceil($request->subtotal);

        if ($promo) {
            if ($pesanan) {
                return 1;
            } else {
                if (now() > $promo->end) {
                    return 2;
                } else {
                    $discount_price = ceil($promo->discount);
                    $subtotal = $amount - $discount_price;
                    $total = ceil($subtotal + $request->ongkir);
                    return [
                        'caption' => $promo->description,
                        'total' => $total,
                        'discount_price' => $discount_price,
                        'str_discount' => '-Rp' . number_format($discount_price, 2, ',', '.'),
                        'str_total' => 'Rp' . number_format($total, 2, ',', '.')
                    ];
                }
            }
        } else {
            return 0;
        }
    }

    public function dashboard()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->orderByDesc('id')->get();

        return view('pages.main.users.dashboard', compact('pesanan'));
    }

    public function downloadFile(Request $request)
    {
        $pesanan = Pesanan::where('uni_code', $request->code)->first();
        $invoice = $pesanan->uni_code . '.pdf';
        $file_path = storage_path('app/public/users/invoice/' . $pesanan->user_id . '/' . $invoice);
        if (file_exists($file_path)) {
            return Response::download($file_path, $invoice, [
                'Content-Length: ' . filesize($file_path)
            ]);
        } else {
            return back()->with('warning', 'File yang Anda minta tidak tersedia!');
        }
    }

    public function received(Request $request)
    {
        $pesanan = Pesanan::where('uni_code', $request->code)->first();
        $pesanan->update(['tgl_diterima' => now()]);

        return back()->with('update', 'Penerimaan paket pesanan [' . $pesanan->uni_code . '] Anda berhasil dikonfirmasi!');
    }

    public function reorder(Request $request)
    {
        $pesanan = Pesanan::where('uni_code', $request->code)->first();
        $carts = Keranjang::whereIn('id', $pesanan->keranjang_ids)->get();

        foreach ($carts as $cart) {
            $produk = $cart->getProduk;
            $harga = $produk->is_diskon == true ? $produk->harga_diskon : $produk->harga;
            $cek = Keranjang::where('user_id', Auth::id())->where('produk_id', $produk->id)->where('isCheckOut', false)->first();

            if ($produk->stock > 0) {
                if ($cek) {
                    $cek->update([
                        'qty' => $cek->qty + 1,
                        'berat' => ($cek->qty + 1) * $produk->berat,
                        'total' => ($cek->qty + 1) * $harga,
                    ]);
                } else {
                    Keranjang::create([
                        'user_id' => Auth::id(),
                        'produk_id' => $produk->id,
                        'qty' => 1,
                        'berat' => $produk->berat,
                        'total' => $harga,
                    ]);
                }

                $produk->update(['stock' => $produk->stock - 1]);
            }
        }

        return back()->with('reorder', 'Semua produk yang masih tersedia dan ada di pesanan ['
            . $pesanan->uni_code . '] berhasil ditambahkan ke cart Anda! Apakah Anda ingin checkout sekarang?');
    }
}
