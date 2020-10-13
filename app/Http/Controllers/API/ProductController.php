<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Produk;
use App\Models\SubKategori;
use App\User;
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
            $get_top_rated= $this->get_top_rated();
            return response()->json(
                [
                    'error' => false,
                    'data' => [
                        'banner' => $banner,
                        'flash_sale' => $flash_sale,
                        'newest' => $newest,
                        'popular' => $popular,
                        'top_rated' =>$get_top_rated
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

    /**
     * TODO filter and Search Produk take as many as Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_product(Request $request)
    {
        try {
            $data = Produk::query()
                ->when($request->get('name'), function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->get('name') . '%');
                })->when($request->get('sub_kategori'), function ($q) use ($request) {
                    $q->whereHas('getSubkategori', function ($q) use ($request) {
                        $q->whereIn('id', $request->sub_kategori);
                    });
                })->when($request->get('jenis'), function ($q) use ($request) {
                    if ($request->jenis == 'retail') {
                        $q->where('isGrosir', false);
                    } elseif ($request->jenis == 'grosir') {
                        $q->where('isGrosir', true);
                    } else {
                        $q->where('isGrosir', false)->orWhere('isGrosir', true);
                    }
                })->where('stock', '>', 0)
                ->orderBy('nama')->get()
                ->take($request->get('limit') ?? 8)->toArray();
            $data = $this->get_image_path($data);

            return response()->json(
                [
                    'error' => false,
                    'data' => [
                        'count_produk' => count($data),
                        'produk' => $data,
                    ]
                ],
                200
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
            ->where('stock', '>', 1)->inRandomOrder()->limit(6)->get([
                'id', 'harga', 'gambar', 'diskon',
                'harga_diskon', 'harga_grosir', 'diskonGrosir', 'harga_diskon_grosir', 'sub_kategori_id'
            ])->toArray();
        $data = $this->get_image_path($data);

        return $data;
    }

    public function get_newest()
    {
        $data = Produk::orderByDesc('created_at')->limit(6)->get([
            'id', 'harga', 'gambar', 'diskon',
            'harga_diskon', 'harga_grosir', 'diskonGrosir', 'harga_diskon_grosir', 'sub_kategori_id'
        ])->toArray();

        $data = $this->get_image_path($data);
        return $data;
    }

    public function get_popular()
    {
        $query = " select * from (SELECT p.id,p.harga, p.gambar, p.diskon, p.harga_diskon,p.harga_grosir,p.diskonGrosir, p.harga_diskon_grosir ,p.sub_kategori_id,count(u.produk_id) as jumlah from produk p left join ulasans u on
                    u.produk_id = p.id group by p.id, p.harga , p.diskon, p.harga_diskon,p.harga_grosir,p.diskonGrosir, p.harga_diskon_grosir, p.gambar,p.sub_kategori_id) a order by jumlah DESC limit 6";
        $data = DB::select(DB::raw($query));
        $data = $this->get_image_path(json_decode(json_encode($data), true));
        return $data;
    }

    public function get_top_rated()
    {
        $data= Produk::where('stock', '>', 0)
            ->withCount(['getUlasan as average_rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg(bintang),0)'));
            }])->orderByDesc('average_rating')->take(6)->get();
            $data = $this->get_image_path($data);
            return $data;
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
            $merge = array_merge($data[$datum], array("image_path" => $filepath), array("sub_name" => SubKategori::find($key['sub_kategori_id'])->nama));
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
            $review = $data->getUlasan->toArray();
            $qna = $data->getQnA->toArray();

            $review = $this->get_detail_ulasan($review);
            $qna = $this->get_detail_ulasan($qna);
            return response()->json([
                'error' => false,
                'data' => [
                    'detail' => $data,
                    'review' => $review,
                    'qna' => $qna
                ]
            ], 200);
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
            ], 500);
        }
    }

    public function get_detail_ulasan($data)
    {
        $array = [];
        foreach ($data as $datum => $key) {
            $user = User::find($key['user_id']);
            if ($user->getBio->ava != 'placeholder.jpg') {
                if (File::exists('storage/user/ava/' . $user->getBio->ava)) {
                    $filepath = asset('storage/user/ava/' . $user->getBio->ava);
                } else {
                    $filepath = asset('storage/produk/banner/placeholder.jpg');
                }
            } else {
                $filepath = asset('storage/produk/banner/placeholder.jpg');
            }
            $merge = array_merge($data[$datum], array("user" => $user->name), array('user_ava' => $filepath));
            array_push($array, $merge);
        }

        return $array;
    }
}
