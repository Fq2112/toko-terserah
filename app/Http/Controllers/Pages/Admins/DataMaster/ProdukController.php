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

    public function add_produk(Request $request)
    {

        $check = Produk::where('kode_barang', $request->kode_barang)->first();
        if (!empty($check)) {
            return back()->with('error', 'Kode Barang ' . $request->kode_barang . ' Telah Ada Silahkan Gunakan Kode Lain');
        }

        $file = $request->file('gambar');
        $filename = uniqid() . $file->getClientOriginalName();
        $file->storeAs('public/produk/thumb/', $filename);
        $produk = Produk::create([
            'nama' => $request->nama,
            'gambar' => $filename,
            'kode_barang' => $request->kode_barang,
            'barcode' => $request->kode_barang,
            'sub_kategori_id' => $request->sub_kategori_id,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'stock' => $request->stock,
            'berat' => $request->berat,
            'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->nama))
        ]);

        if ($request->has('galeri')) {
            $files = $request->file('galeri');
            $img = array();
            foreach ($files as $fileGaleri) {
                $extention = $fileGaleri->getClientOriginalExtension();
                $filenames = uniqid() . $fileGaleri->getClientOriginalName();
                $fileGaleri->storeAs('public/produk/galeri/', $filenames);
                array_push($img, $filenames);
            }
            $produk->update([
                'galeri' => $img
            ]);
        }

        if ($request->diskon != null) {
            $diskon = $produk->harga * ($request->diskon / 100);
            $produk->update([
                'is_diskon' => true,
                'diskon' => $request->diskon,
                'harga_diskon' => $produk->harga - $diskon
            ]);
        }


        return redirect()->route('admin.show.produk')->with('success', 'Berhasil Menambahkan Produk');
    }
}
