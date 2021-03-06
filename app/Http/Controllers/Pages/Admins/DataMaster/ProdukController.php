<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;


class ProdukController extends Controller
{
    public function show(Request $request)
    {
        return view('pages.main.admins.produk.produk');
    }

    public function getProduk()
    {
        $data = Produk::query()
            ->get(['id', 'barcode', 'nama', 'harga', 'stock', 'is_diskon', 'harga_diskon', 'isGrosir', 'harga_grosir', 'isDiskonGrosir', 'diskonGrosir', 'sub_kategori_id']);

        $datatable = DataTables::of($data)
            ->addColumn('kategori', function ($data) {
                if (!empty($data->sub_kategori_id)) {
                    $kategori = $data->getSubkategori->nama;
                } else {
                    $kategori = "-";
                }
                return $kategori;
            })
            ->addColumn('diskon_percent', function ($data) {
                return $data->diskon ?? '0';
            })
            ->addColumn('harga_diskon', function ($data) {
                if ($data->is_diskon == 1) {
                    $show = '<strike>' . number_format($data->harga) . '</strike><br>
                                <span class="text-danger">' . number_format($data->harga_diskon) . '</span>';
                } else {
                    $show = number_format($data->harga);
                }
                return $show;
            })->addColumn('diskon_percent_grosir', function ($data) {
                return $data->diskonGrosir ?? '0';
            })->addColumn('harga_diskon_grosir', function ($data) {
                if ($data->isDiskonGrosir == 1) {
                    $show = '<strike>' . number_format($data->harga_grosir) . '</strike><br>
                                <span class="text-danger">' . number_format($data->harga_diskon_grosir) . '</span>';
                } else {
                    $show = number_format($data->harga_grosir);
                }
                return $show;
            })->addColumn('stock_sec', function ($data) {
                $action = view('pages.main.admins.produk.stock', [
                    'item' => $data
                ]);
                return $action;
            })
            ->addColumn('action', function ($data) {
                $action = view('pages.main.admins.produk.button_action', [
                    'item' => $data,
                ]);
                return $action;
            })
            ->rawColumns(['harga_diskon', 'harga_diskon_grosir', 'stock_sec', 'action']);;

//            dd($datatable);

        return $datatable->make(true);
    }

    public function habis(Request $request)
    {
        if($request->ajax()){
            $data = Produk::query()->where('stock', '<=', 10)
                ->get(['id', 'barcode', 'nama', 'harga', 'stock', 'is_diskon', 'harga_diskon', 'isGrosir', 'harga_grosir', 'isDiskonGrosir', 'diskonGrosir', 'sub_kategori_id']);

            $datatable = DataTables::of($data)
                ->addColumn('kategori', function ($data) {
                    if (!empty($data->sub_kategori_id)) {
                        $kategori = $data->getSubkategori->nama;
                    } else {
                        $kategori = "-";
                    }
                    return $kategori;
                })
                ->addColumn('diskon_percent', function ($data) {
                    return $data->diskon ?? '0';
                })
                ->addColumn('harga_diskon', function ($data) {
                    if ($data->is_diskon == 1) {
                        $show = '<strike>' . number_format($data->harga) . '</strike><br>
                                <span class="text-danger">' . number_format($data->harga_diskon) . '</span>';
                    } else {
                        $show = number_format($data->harga);
                    }
                    return $show;
                })->addColumn('diskon_percent_grosir', function ($data) {
                    return $data->diskonGrosir ?? '0';
                })->addColumn('harga_diskon_grosir', function ($data) {
                    if ($data->isDiskonGrosir == 1) {
                        $show = '<strike>' . number_format($data->harga_grosir) . '</strike><br>
                                <span class="text-danger">' . number_format($data->harga_diskon_grosir) . '</span>';
                    } else {
                        $show = number_format($data->harga_grosir);
                    }
                    return $show;
                })->addColumn('stock_sec', function ($data) {
                    $action = view('pages.main.admins.produk.stock', [
                        'item' => $data
                    ]);
                    return $action;
                })
                ->addColumn('action', function ($data) {
                    $action = view('pages.main.admins.produk.button_action', [
                        'item' => $data,
                    ]);
                    return $action;
                })
                ->rawColumns(['harga_diskon', 'harga_diskon_grosir', 'stock_sec', 'action']);;

//            dd($datatable);

            return $datatable->make(true);
        }

        return view('pages.main.admins.produk.habis');
    }

    public function add_product_page()
    {
        return view('pages.main.admins.produk._partial.tambah_produk');
    }

    public function show_barcode(Request $request)
    {
        try {
            $data = Produk::query()->select(['barcode', 'nama'])->findOrFail($request->id);
            return view('pages.main.admins.produk._partial.barcode', [
                'data' => $data
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
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
        $setting = Setting::query()->where('id', '!=', 0)->first();
//        if (!empty($check)) {
//            return back()->with('error', 'Kode Barang ' . $request->kode_barang . ' Telah Ada Silahkan Gunakan Kode Lain');
//        }

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
            'actual_weight' => $request->berat,
            'berat' => $request->berat + ($request->berat * ($setting->percent_weight / 100)),
            'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->nama)),
            'harga_grosir' => $request->harga_grosir,
            'galeri' => [],
            'min_qty' => $request->min_qty,
        ]);

        if ($request->harga_grosir > 0) {
            $produk->update([
                'isGrosir' => true
            ]);
        }

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


        if ($request->diskonGrosir != null) {
            $diskonGrosir = $produk->harga_grosir * ($request->diskonGrosir / 100);
            $produk->update([
                'isDiskonGrosir' => true,
                'diskonGrosir' => $request->diskonGrosir,
                'min_qty' => $request->min_qty,
                'harga_diskon_grosir' => $produk->harga_grosir - $diskonGrosir
            ]);
        }


        return redirect()->route('admin.show.produk')->with('success', 'Berhasil Menambahkan Produk');
    }

    public function edit($kode_barang)
    {
        try {
            $data = Produk::query()->findOrFail(decrypt($kode_barang));

            return view('pages.main.admins.produk._partial.edit_produk', [
                'data' => $data
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.show.produk')->with('error', 'Kode Tidak Ditemukan');
        }
    }

    public function update_produk(Request $request)
    {
        $data = Produk::find($request->id);
        $setting = Setting::query()->where('id', '!=', 0)->first();

        $data->update([
            'nama' => $request->nama,
            'kode_barang' => $request->kode_barang,
            'barcode' => $request->kode_barang,
            'sub_kategori_id' => $request->sub_kategori_id,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'stock' => $request->stock,
            'actual_weight' => $request->berat,
            'berat' => $request->berat + ($request->berat * ($setting->percent_weight / 100)),
            'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->nama)),
            'is_diskon' => false,
            'harga_diskon' => 0,
            'harga_grosir' => $request->harga_grosir,
            'min_qty' => $request->min_qty,
        ]);

        if ($request->harga_grosir < 1 || $request->harga_grosir == null) {
            $data->update([
                'isGrosir' => false
            ]);
        }

        if ($request->harga_grosir > 0) {
            $data->update([
                'isGrosir' => true
            ]);
        }

        if ($request->has('gambar')) {
            $file = $request->file('gambar');
            $filename = uniqid() . $file->getClientOriginalName();
            $file->storeAs('public/produk/thumb/', $filename);
            //delete file lama
            if ($data->gambar != 'placeholder.jpg') {
                if (File::exists('storage/produk/thumb/' . $data->gambar)) {
                    File::delete('storage/produk/thumb/' . $data->gambar);
                }
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

        if ($request->diskonGrosir != null) {
            $diskonGrosir = $data->harga_grosir * ($request->diskonGrosir / 100);
            $data->update([
                'isDiskonGrosir' => true,
                'diskonGrosir' => $request->diskonGrosir,
                'harga_diskon_grosir' => $data->harga_grosir - $diskonGrosir
            ]);
        }


        if ($request->has('temp_photos')) {
            $img = $data->galeri;
            $base_path = "upload/product/";
            foreach ($request->temp_photos as $item) {
                $key = array_search($item, $img);
                array_splice($img, $key, 1);
                //deleting Image
                if ($item != 'placeholder.jpg') {
                    if (File::exists('storage/produk/galeri/' . $item)) {
                        File::delete('storage/produk/galeri/' . $item);
                    }
                }
            }
            $data->update([
                'galeri' => $img
            ]);
        }

        if ($request->has('galeri')) {
            $files = $request->file('galeri');
            $img = $data->galeri ?? [];
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
