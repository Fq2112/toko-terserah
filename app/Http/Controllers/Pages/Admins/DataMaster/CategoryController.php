<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show_kategori()
    {
        return view('pages.main.admins.master.kategori', [
            'data' => Kategori::all()
        ]);
    }

    public function create_kategori(Request $request)
    {
        $file = $request->file('thumb');
        $filename = uniqid() . $file->getClientOriginalName();
        $file->storeAs('public/produk/kategori/', $filename);

        Kategori::create([
            'nama' => $request->nama,
            'thumb' => $filename,
            'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->nama))
        ]);

        return back()->with('success', 'Berhasil menambahkan data kategori');
    }

    public function delete_kategori($id)
    {
        $data = Kategori::find($id);

        $data->delete();

        return back()->with('success', 'Berhasil menghapus data kategori');
    }

    public function update_kategori(Request $request)
    {
        $data = Kategori::find($request->id_kategori);
        $data->update([
           'nama' => $request->nama
        ]);

        if ($request->has('thumb')) {
            $file = $request->file('thumb');
            $filename = uniqid() . $file->getClientOriginalName();
            $file->storeAs('public/produk/kategori/', $filename);
            $data->update([
                'thumb' => $filename
            ]);
        }
        return back()->with('success', 'Berhasil memperbarui data kategori');
    }

    public function show_sub()
    {
        return view('pages.main.admins.master.sub', [
            'data' => SubKategori::all()
        ]);
    }


}
