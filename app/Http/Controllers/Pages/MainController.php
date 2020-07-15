<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\SubKategori;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function beranda()
    {
        $kategori = Kategori::orderBy('nama')->get();

        return view('pages.main.beranda', compact('kategori'));
    }

    public function produk(Request $request)
    {
        $sub = SubKategori::where('permalink->en', $request->produk)
            ->orwhere('permalink->id', $request->produk)->whereHas('getCluster')->first();
        $clust = ClusterKategori::where('permalink->en', $request->produk)
            ->orwhere('permalink->id', $request->produk)->first();
        $provinces = Province::all();
        $addresses = Address::where('user_id', Auth::id())->orderByDesc('id')->get();

        $cart = $request->has('cart_id') ? Cart::find(decrypt($request->cart_id)) : null;
        $shipping = !is_null($cart) ? Address::find($cart->address_id) : null;

        if (!is_null($sub)) {
            $data = $sub;

            if (count($data->getCluster) > 0) {
                return view('pages.main.produk', compact('data'));

            } else {
                $specs = $data->getSubkatSpecs;

                return view('pages.main.form-pemesanan', compact('clust', 'data', 'provinces',
                    'specs', 'addresses', 'cart', 'shipping'));
            }

        } elseif (!is_null($clust)) {
            $data = $clust;
            $specs = $data->getClusterSpecs;

            return view('pages.main.form-pemesanan', compact('clust', 'data', 'provinces',
                'specs', 'addresses', 'cart', 'shipping'));
        }

        return back();
    }

    public function submitPemesanan(Request $request)
    {
        $sub = SubKategori::where('permalink->en', $request->produk)
            ->orwhere('permalink->id', $request->produk)->whereHas('getCluster')->first();
        $clust = ClusterKategori::where('permalink->en', $request->produk)
            ->orwhere('permalink->id', $request->produk)->first();

        if ($request->hasFile('file')) {
            $this->validate($request, ['file' => 'required|mimes:jpg,jpeg,png,tiff,pdf,zip,rar|max:204800']);
            $file = $request->file('file')->getClientOriginalnama();
            $request->file('file')->storeAs('public/users/order/design/' . Auth::id(), $file);
            $link = null;
        } else {
            $file = null;
            $link = $request->link;
        }

        Cart::create([
            'user_id' => Auth::id(),
            'subkategori_id' => !is_null($sub) ? $sub->id : null,
            'cluster_id' => !is_null($clust) ? $clust->id : null,
            'address_id' => $request->address_id,
            'material_id' => $request->materials,
            'type_id' => $request->type,
            'balance_id' => $request->balance,
            'page_id' => $request->page,
            'copies_id' => $request->copies,
            'size_id' => $request->size,
            'width' => $request->width,
            'length' => $request->length,
            'lamination_id' => $request->lamination,
            'side_id' => $request->side,
            'edge_id' => $request->corner,
            'color_id' => $request->color,
            'finishing_id' => $request->finishing,
            'folding_id' => $request->folding,
            'front_side_id' => $request->front_side,
            'right_side_id' => $request->right_side,
            'left_side_id' => $request->left_side,
            'back_side_id' => $request->back_side,
            'front_cover_id' => $request->front_cover,
            'back_cover_id' => $request->back_cover,
            'binding_id' => $request->binding,
            'print_method_id' => $request->print_method,
            'material_cover_id' => $request->cover_material,
            'side_cover_id' => $request->cover_side,
            'cover_lamination_id' => $request->cover_lamination,
            'lid_id' => $request->lid,
            'orientation_id' => $request->orientation,
            'extra_id' => $request->extra,
            'holder_id' => $request->holder,
            'material_color_id' => $request->material_color,
            'qty' => $request->qty,
            'price_pcs' => $request->price_pcs,
            'production_finished' => $request->production_finished,
            'ongkir' => $request->ongkir,
            'delivery_duration' => $request->delivery_duration,
            'received_date' => $request->received_date,
            'total' => $request->total,
            'file' => $file,
            'link' => $link,
        ]);

        $message = !is_null($sub) ? $sub->nama : $clust->nama;

        return redirect()->route('beranda')->with('order', 'Produk cetak [' . $message . '] Anda berhasil ditambahkan ke dalam keranjang belanja Anda! Apakah Anda ingin menyelesaikan pembayarannya sekarang?');
    }

    public function updatePemesanan(Request $request)
    {
        $cart = Cart::find($request->id);

        if ($request->hasFile('file')) {
            $this->validate($request, ['file' => 'required|mimes:jpg,jpeg,png,tiff,pdf,zip,rar|max:204800']);
            $file = $request->file('file')->getClientOriginalnama();
            if ($cart->file != '') {
                Storage::delete('public/users/order/design/' . Auth::id() . '/' . $cart->file);
            }
            $request->file('file')->storeAs('public/users/order/design/' . Auth::id(), $file);
            $link = null;
        } else {
            if (is_null($request->link)) {
                $file = $cart->file;
                $link = null;
            } else {
                if ($cart->file != '') {
                    Storage::delete('public/users/order/design/' . Auth::id() . '/' . $cart->file);
                }
                $file = null;
                $link = $request->link;
            }
        }

        $cart->update([
            'address_id' => $request->address_id,
            'material_id' => $request->materials,
            'type_id' => $request->type,
            'balance_id' => $request->balance,
            'page_id' => $request->page,
            'copies_id' => $request->copies,
            'size_id' => $request->size,
            'width' => $request->width,
            'length' => $request->length,
            'lamination_id' => $request->lamination,
            'side_id' => $request->side,
            'edge_id' => $request->corner,
            'color_id' => $request->color,
            'finishing_id' => $request->finishing,
            'folding_id' => $request->folding,
            'front_side_id' => $request->front_side,
            'right_side_id' => $request->right_side,
            'left_side_id' => $request->left_side,
            'back_side_id' => $request->back_side,
            'front_cover_id' => $request->front_cover,
            'back_cover_id' => $request->back_cover,
            'binding_id' => $request->binding,
            'print_method_id' => $request->print_method,
            'material_cover_id' => $request->cover_material,
            'side_cover_id' => $request->cover_side,
            'cover_lamination_id' => $request->cover_lamination,
            'lid_id' => $request->lid,
            'orientation_id' => $request->orientation,
            'extra_id' => $request->extra,
            'holder_id' => $request->holder,
            'material_color_id' => $request->material_color,
            'qty' => $request->qty,
            'price_pcs' => $request->price_pcs,
            'production_finished' => $request->production_finished,
            'ongkir' => $request->ongkir,
            'delivery_duration' => $request->delivery_duration,
            'received_date' => $request->received_date,
            'total' => $request->total,
            'file' => $file,
            'link' => $link,
        ]);

        $message = !is_null($cart->subkategori_id) ? $cart->getSubKategori->nama : $cart->getCluster->nama;

        return redirect()->route('beranda')->with('order', 'Pesanan produk cetak [' . $message . '] Anda berhasil diperbarui! Apakah Anda ingin menyelesaikan pembayarannya sekarang?');
    }

    public function deletePemesanan(Request $request)
    {
        $cart = Cart::find(decrypt($request->id));
        if ($cart->file != '') {
            Storage::delete('public/users/order/design/' . Auth::id() . '/' . $cart->file);
        }
        $cart->delete();

        $message = !is_null($cart->subkategori_id) ? $cart->getSubKategori->nama : $cart->getCluster->nama;

        return back()->with('delete', 'Pesanan produk cetak [' . $message . '] Anda berhasil dihapuskan dari keranjang Anda!');
    }
}
