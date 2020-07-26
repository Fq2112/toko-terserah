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

        $archive = Keranjang::whereIn('id', explode(",", $cart_ids))
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
                    $discount_price = ceil($amount * $promo->discount / 100);
                    $subtotal = $amount - $discount_price;
                    $total = ceil($subtotal + $request->ongkir);
                    return [
                        'caption' => $promo->description,
                        'discount' => $promo->discount,
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

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $bio = $user->getBio;
        $keyword = $request->q;
        $category = $request->filter;

        $archive_unpaid = PaymentCart::where('user_id', $user->id)->where('finish_payment', false)
            ->whereHas('getCart', function ($q) use ($user) {
                $q->where('user_id', $user->id)->where('isCheckOut', true)->doesntHave('getOrder');
            })->when($keyword, function ($q) use ($keyword, $user) {
                $q->where('uni_code_payment', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('getCart', function ($q) use ($keyword, $user) {
                        $q->whereHas('getSubKategori', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->where('user_id', $user->id)->where('isCheckOut', true)->doesntHave('getOrder')
                            ->orWhereHas('getCluster', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->where('user_id', $user->id)->where('isCheckOut', true)->doesntHave('getOrder');
                    })->where('user_id', $user->id)->where('finish_payment', false);
            })->orderByDesc('id')->get()->groupBy('uni_code_payment');
        $unpaid = $archive_unpaid;

        $archive_paid = PaymentCart::where('user_id', $user->id)->where('finish_payment', true)
            ->whereHas('getCart', function ($q) use ($user) {
                $q->where('user_id', $user->id)->where('isCheckOut', true)->doesntHave('getOrder');
            })->when($keyword, function ($q) use ($keyword, $user) {
                $q->where('uni_code_payment', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('getCart', function ($q) use ($keyword, $user) {
                        $q->whereHas('getSubKategori', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->where('user_id', $user->id)->where('isCheckOut', true)->doesntHave('getOrder')
                            ->orWhereHas('getCluster', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->where('user_id', $user->id)->where('isCheckOut', true)->doesntHave('getOrder');
                    })->where('user_id', $user->id)->where('finish_payment', true);
            })->orderByDesc('id')->get()->groupBy('uni_code_payment');
        $paid = $archive_paid;

        $archive_produced = Order::where('progress_status', StatusProgress::START_PRODUCTION)
            ->whereHas('getCart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->when($keyword, function ($q) use ($keyword, $user) {
                $q->where('uni_code', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('getCart', function ($q) use ($keyword, $user) {
                        $q->whereHas('getSubKategori', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->where('user_id', $user->id)
                            ->orWhereHas('getCluster', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->where('user_id', $user->id);
                    })->where('progress_status', StatusProgress::START_PRODUCTION);
            })->orWhere('progress_status', StatusProgress::FINISH_PRODUCTION)
            ->whereHas('getCart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->when($keyword, function ($q) use ($keyword, $user) {
                $q->where('uni_code', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('getCart', function ($q) use ($keyword, $user) {
                        $q->whereHas('getSubKategori', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->where('user_id', $user->id)
                            ->orWhereHas('getCluster', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->where('user_id', $user->id);
                    })->where('progress_status', StatusProgress::FINISH_PRODUCTION);
            })->orderByDesc('updated_at')->get()->groupBy('uni_code');
        $produced = $archive_produced;

        $archive_shipped = Order::where('progress_status', StatusProgress::SHIPPING)
            ->whereHas('getCart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->when($keyword, function ($q) use ($keyword, $user) {
                $q->where('uni_code', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('getCart', function ($q) use ($keyword, $user) {
                        $q->whereHas('getSubKategori', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->where('user_id', $user->id)
                            ->orWhereHas('getCluster', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->where('user_id', $user->id);
                    })->where('progress_status', StatusProgress::SHIPPING);
            })->orderByDesc('updated_at')->get()->groupBy('uni_code');
        $shipped = $archive_shipped;

        $archive_received = Order::where('progress_status', StatusProgress::RECEIVED)
            ->whereHas('getCart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->when($keyword, function ($q) use ($keyword, $user) {
                $q->where('uni_code', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('getCart', function ($q) use ($keyword, $user) {
                        $q->whereHas('getSubKategori', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->where('user_id', $user->id)
                            ->orWhereHas('getCluster', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->where('user_id', $user->id);
                    })->where('progress_status', StatusProgress::RECEIVED);
            })->orderByDesc('updated_at')->get()->groupBy('uni_code');
        $received = $archive_received;

        $all = count($paid) + count($unpaid) + count($produced) + count($shipped) + count($received);

        return view('pages.main.users.dashboard', compact('user', 'bio', 'keyword', 'category',
            'unpaid', 'paid', 'produced', 'shipped', 'received', 'all'));
    }

    public function downloadFile(Request $request)
    {
        $cart = Cart::find(decrypt($request->id));

        if ($request->file == 'design') {
            if (!is_null($cart->file)) {
                $file_path = storage_path('app/public/users/order/design/' . $cart->user_id . '/' . $cart->file);
                if (file_exists($file_path)) {
                    return Response::download($file_path, $cart->file, [
                        'Content-Length: ' . filesize($file_path)
                    ]);
                } else {
                    return 0;
                }
            } else {
                return $cart->link;
            }

        } else {
            $invoice = $cart->getPayment->uni_code_payment . '.pdf';
            $file_path = storage_path('app/public/users/order/invoice/' . $cart->user_id . '/' . $invoice);
            if (file_exists($file_path)) {
                return Response::download($file_path, $invoice, [
                    'Content-Length: ' . filesize($file_path)
                ]);
            } else {
                return 0;
            }
        }
    }

    public function received(Request $request)
    {
        $order = Order::where('uni_code', $request->code)->first();
        $data = !is_null($order->getCart->subkategori_id) ? $order->getCart->getSubKategori : $order->getCart->getCluster;

        $order->update(['progress_status' => StatusProgress::RECEIVED]);

        return back()
            ->with('update', __('lang.alert.order-received', ['code' => $order->uni_code, 'name' => $data->name]));
    }

    public function reorder(Request $request)
    {
        $order = Order::where('uni_code', $request->code)->first();
        $cart = $order->getCart;

        Cart::create([
            'user_id' => $cart->user_id,
            'subkategori_id' => !is_null($cart->subkategori_id) ? $cart->subkategori_id : null,
            'cluster_id' => !is_null($cart->cluster_id) ? $cart->cluster_id : null,
            'address_id' => $cart->address_id,
            'material_id' => $cart->material_id,
            'type_id' => $cart->type_id,
            'balance_id' => $cart->balance_id,
            'page_id' => $cart->page_id,
            'copies_id' => $cart->copies_id,
            'size_id' => $cart->size_id,
            'width' => $cart->width,
            'length' => $cart->length,
            'lamination_id' => $cart->lamination_id,
            'side_id' => $cart->side_id,
            'edge_id' => $cart->edge_id,
            'color_id' => $cart->color_id,
            'finishing_id' => $cart->finishing_id,
            'folding_id' => $cart->folding_id,
            'front_side_id' => $cart->front_side_id,
            'right_side_id' => $cart->right_side_id,
            'left_side_id' => $cart->left_side_id,
            'back_side_id' => $cart->back_side_id,
            'front_cover_id' => $cart->front_cover_id,
            'back_cover_id' => $cart->back_cover_id,
            'binding_id' => $cart->binding_id,
            'print_method_id' => $cart->print_method_id,
            'material_cover_id' => $cart->material_cover_id,
            'side_cover_id' => $cart->side_cover_id,
            'cover_lamination_id' => $cart->cover_lamination_id,
            'lid_id' => $cart->lid_id,
            'orientation_id' => $cart->orientation_id,
            'extra_id' => $cart->extra_id,
            'holder_id' => $cart->holder_id,
            'material_color_id' => $cart->material_color_id,
            'qty' => $cart->qty,
            'price_pcs' => $cart->price_pcs,
            'production_finished' => $cart->production_finished,
            'ongkir' => $cart->ongkir,
            'delivery_duration' => $cart->delivery_duration,
            'received_date' => $cart->received_date,
            'total' => $cart->total,
            'file' => $cart->file,
            'link' => $cart->link,
        ]);

        return redirect()->route('user.cart')->with('add', __('lang.alert.reorder-cart',
            ['param' => !is_null($cart->subkategori_id) ? $cart->getSubKategori->name : $cart->getCluster->name]));
    }
}
