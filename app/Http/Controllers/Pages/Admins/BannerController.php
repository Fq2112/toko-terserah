<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function create_data(Request $request)
    {
        $banner = $request->file('banner');
        $bannerName = uniqid() . $banner->getClientOriginalName();
        $banner->storeAs('public/produk/banner/', $bannerName);

        Banner::create([
            'banner' => $bannerName,
            'produk' => $request->produk
        ]);

        return back()->with('success', 'Berhasi Menambahkan Banner');
    }

    public function edit(Request $request)
    {
        $data = Banner::find($request->id);

        $data->update([
            'produk' => $request->produk
        ]);

        if ($request->has('banner')) {
            $banner = $request->file('banner');
            $bannerName = uniqid() . $banner->getClientOriginalName();
            $banner->storeAs('public/produk/banner/', $bannerName);
            $data->update([
                'banner' => $bannerName,
            ]);
        }
        return back()->with('success', 'Berhasi Memperbarui Banner');
    }

    public function delete($id)
    {
        $data = Banner::find($id);
        $data->delete();

        return back()->with('success', 'Berhasi Menghapus Banner');
    }
}
