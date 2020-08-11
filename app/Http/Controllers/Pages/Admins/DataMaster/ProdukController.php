<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        if ($request->has('banner')) {
            $banner = $request->file('banner');
            $bannerName = uniqid() . $banner->getClientOriginalName();
            $banner->storeAs('public/produk/banner/', $bannerName);

            $produk->update([
                'is_banner' => true,
                'banner' => $bannerName
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

    public function edit($kode_barang)
    {
        $data = Produk::where('kode_barang', $kode_barang)->first();

        return view('pages.main.admins.produk._partial.edit_produk', [
            'data' => $data
        ]);
    }

    public function update_produk(Request $request)
    {
        $data = Produk::find($request->id);
        $data->update([
            'nama' => $request->nama,
            'kode_barang' => $request->kode_barang,
            'barcode' => $request->kode_barang,
            'sub_kategori_id' => $request->sub_kategori_id,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'stock' => $request->stock,
            'berat' => $request->berat,
            'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->nama)),
            'is_diskon' => false,
            'harga_diskon' => 0
        ]);

        if ($request->has('gambar')) {
            $file = $request->file('gambar');
            $filename = uniqid() . $file->getClientOriginalName();
            $file->storeAs('public/produk/thumb/', $filename);
            //delete file lama
            if (File::exists('storage/produk/thumb/' . $data->gambar)) {
                File::delete('storage/produk/thumb/' . $data->gambar);
            }
            $data->update([
                'gambar' => $filename
            ]);
        }


        if ($request->diskon != null) {
            $diskon = $data->harga * ($request->diskon / 100);
            $data->update([
                'is_diskon' => true,
                'diskon' => $request->diskon,
                'harga_diskon' => $data->harga - $diskon
            ]);
        }


        if ($request->has('temp_photos')) {
            $img = $data->galeri;
            $base_path = "upload/product/";
            foreach ($request->temp_photos as $item) {
                $key = array_search($item, $img);
                array_splice($img, $key, 1);
                //deleting Image
                if (File::exists('storage/produk/galeri/' . $item)) {
                    File::delete('storage/produk/galeri/' . $item);
                }
            }
            $data->update([
                'galeri' => $img
            ]);
        }

        if ($request->has('galeri')) {
            $files = $request->file('galeri');
            $img = $data->galeri;
            foreach ($files as $fileGaleri) {
                $extention = $fileGaleri->getClientOriginalExtension();
                $filenames = uniqid() . $fileGaleri->getClientOriginalName();
                $fileGaleri->storeAs('public/produk/galeri/', $filenames);
                array_push($img, $filenames);
            }
            $data->update([
                'galeri' => $img
            ]);
        }

        if ($request->has('hapus_banner')) {
            if ($data->banner != 'placeholder.jpg') {
                if (File::exists('storage/produk/banner/' . $data->banner)) {
                    File::delete('storage/produk/banner/' . $data->banner);
                }
                $data->update([
                    'is_banner' => false,
                    'banner' => null
                ]);
            } else {

            }
        }


        if ($request->has('banner')) {
            $banner = $request->file('banner');
            $bannerName = uniqid() . $banner->getClientOriginalName();
            $banner->storeAs('public/produk/banner/', $bannerName);

            $data->update([
                'is_banner' => true,
                'banner' => $bannerName
            ]);
        }

        return redirect()->route('admin.show.produk')->with('success', 'Produk ' . $data->nama . ' Berhasil Diperbarui');
    }

    public function delete_produk($id)
    {
        $data = Produk::find($id);
        $data->delete();

        return back()->with('success', 'Produk Berhasil Dihapus');
    }
}
