<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function show(Request $request)
    {
        $data = Produk::all();

        return view('pages.main.admins.produk.produk', [
            'data' => $data
        ]);
    }

    public function add_product_page()
    {
        return view('pages.main.admins.produk._partial.tambah_produk');
    }

    public function add_stock(Request $request)
    {
        try {
            $data = Produk::find($request->id_produk);
            $data->update([
                'stock' => $request->stock_produk
            ]);

            return back()->with('success', 'Stok' . $data->nama . ' Berhasil Ditambah');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
