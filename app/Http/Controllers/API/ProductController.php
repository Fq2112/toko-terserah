<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Produk;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function home_mobile()
    {
        try {
            $banner = $this->get_banner();
            $flash_sale = $this->get_flash_sale();
            $newest = $this->get_newest();
            $popular = $this->get_popular();
            return response()->json(
                [
                    'error' => false,
                    'data' => [
                        'banner' => $banner,
                        'flash_sale' => $flash_sale,
                        'newest' => $newest,
                        'popular' => $popular
                    ]
                ]
            );
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function get_flash_sale()
    {
        $data = Produk::where('is_diskon', true)
            ->where('stock', '>', 1)->inRandomOrder()->limit(6)->get(['id', 'harga', 'gambar', 'diskon',
                'harga_diskon', 'harga_grosir', 'diskonGrosir', 'harga_diskon_grosir'])->toArray();
        $data = $this->get_image_path($data);

        return $data;
    }

    public function get_newest()
    {
        $data = Produk::orderByDesc('created_at')->limit(6)->get(['id', 'harga', 'gambar', 'diskon',
            'harga_diskon', 'harga_grosir', 'diskonGrosir', 'harga_diskon_grosir'])->toArray();

        $data = $this->get_image_path($data);
        return $data;
    }

    public function get_popular()
    {
        $query = " select * from (SELECT p.id,p.harga, p.gambar, p.diskon, p.harga_diskon,p.harga_grosir,p.diskonGrosir, p.harga_diskon_grosir,count(u.produk_id) as jumlah from produk p left join ulasans u on
                    u.produk_id = p.id group by p.id, p.harga , p.diskon, p.harga_diskon,p.harga_grosir,p.diskonGrosir, p.harga_diskon_grosir, p.gambar) a order by jumlah DESC limit 6";
        $data = DB::select(DB::raw($query));
        $data = $this->get_image_path(json_decode(json_encode($data), true));
        return $data;
    }

    public function get_top_rated()
    {

    }

    public function get_image_path($data)
    {
        $array = [];
        foreach ($data as $datum => $key) {
            if ($key['gambar'] == "placeholder.jpg" || $key['gambar'] == "") {
                $filepath = asset('storage/produk/galeri/' . $key['gambar']);
            } else {
                $filepath = asset('storage/produk/galeri/' . $key['gambar']);
            }
            $merge = array_merge($data[$datum], array("image_path" => $filepath));
            array_push($array, $merge);
        }
        return $array;
    }

    public function get_banner()
    {
        $data = Banner::all()->toArray();
        $array = [];
        foreach ($data as $datum => $key) {
            if ($key['banner'] != 'placeholder.jpg') {
                if (File::exists('storage/produk/banner/' . $key['banner'])) {
                    $filepath = asset('storage/produk/banner/' . $key['banner']);
                } else {
                    $filepath = asset('storage/produk/banner/placeholder.jpg');
                }
            } else {
                $filepath = asset('storage/produk/banner/placeholder.jpg');
            }

            $merge = array_merge($data[$datum], array("image_path" => $filepath));
            array_push($array, $merge);
        }

        return $array;
    }


    public function get_detail($id)
    {
        try {
            $data = Produk::find($id);
            return response()->json([
                'error' => true,
                'data' => [
                    'detail' => $data
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }
}
