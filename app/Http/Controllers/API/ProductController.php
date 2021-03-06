<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Favorit;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\PromoCode;
use App\Models\SubKategori;
use App\Models\Ulasan;
use App\Models\VouucherUser;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use JWTAuth;


class ProductController extends Controller
{
    public function home_mobile()
    {

        try {
            $user = auth('api')->user();
            $date = now()->format('Y-m-d');
            $banner = $this->get_banner();
            $flash_sale = $this->get_flash_sale();
            $newest = $this->get_newest();
            $popular = $this->get_popular();
            $get_top_rated = $this->get_top_rated();

            $promo_count = PromoCode::select('id')
                ->whereDate('start', '<=', $date)
                ->whereDate('end', '>=', $date)
                ->when($user, function ($q) use ($user) {
                    $except = Pesanan::where('user_id', $user->id)->whereNotNull('promo_code')->pluck('promo_code');
                    return $q->whereNotIn('promo_code', $except);
                })->count();
            return response()->json(
                [
                    'error' => false,
                    'data' => [
                        'voucher_count' => $promo_count,
                        'banner' => $banner,
                        'flash_sale' => $flash_sale,
                        'newest' => $newest,
                        'popular' => $popular,
                        'top_rated' => $get_top_rated,
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
                ->when($request->kategori, function ($q) use ($request) {
                    $q->whereHas('getSubkategori', function ($q) use ($request) {
                        $q->whereIn('id', explode(',', $request->kategori));
                    });
                })
                ->when($request->get('name'), function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->get('name') . '%');
                })->when($request->get('sub_kategori'), function ($q) use ($request) {
                    $q->whereHas('getSubkategori', function ($q) use ($request) {
                        $q->whereIn('id', $request->sub_kategori);
                    });
                })->when($request->get('awal'), function ($q) use ($request) {
                    $q->whereBetween(
                        DB::raw("IF(isGrosir=0, IF(is_diskon=0, CAST(harga as UNSIGNED), CAST(harga_diskon as UNSIGNED)), IF(isDiskonGrosir=0, CAST(harga_grosir as UNSIGNED), CAST(harga_diskon_grosir as UNSIGNED)))"),
                        [$request->get('awal'), $request->get('akhir')]
                    );
                })
                ->when($request->get('jenis'), function ($q) use ($request) {
                    if ($request->jenis == 'retail') {
                        $q->where('isGrosir', false);
                    } elseif ($request->jenis == 'grosir') {
                        $q->where('isGrosir', true);
                    }
                })->where('stock', '>', 0)
                ->orderBy('nama')->get()
                ->take($request->get('limit') ?? 8)->toArray();

            foreach ($data as $i => $row) {
                $ulasan = Ulasan::where('produk_id', $row['id'])->get();
                $data[$i] = array_merge($data[$i], [
                    'avg_ulasan' => count($ulasan) > 0 ? $ulasan->avg('bintang') : 0,
                    'count_ulasan' => count($ulasan)
                ]);
            }


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
        $data = Produk::where('stock', '>', 0)->where('is_diskon', true)->orWhere('isDiskonGrosir', true)->where('stock', '>', 0)
            ->inRandomOrder()->limit(6)->get([
                'id', 'harga', 'gambar', 'diskon', 'nama', 'isGrosir',
                'harga_diskon', 'harga_grosir', 'diskonGrosir', 'harga_diskon_grosir', 'sub_kategori_id'
            ])->toArray();
        $res = [];

        foreach ($data as $i => $row) {
            $ulasan = Ulasan::where('produk_id', $row['id'])->get();
            $row['count_ulasan'] = 0;
            $row['avg_ulasan'] = 0;


            foreach ($ulasan as $ls) {
                $row['count_ulasan'] = $row['count_ulasan'] + 1;
                $row['avg_ulasan'] = $row['avg_ulasan'] + $ls->bintang;
            }
            $row['avg_ulasan'] = $row['avg_ulasan'] ? $row['avg_ulasan'] / $row['count_ulasan'] : 0;
            $res[] = $row;
        }

        $data = $this->get_image_path($res);

        return $res;
    }

    public function get_newest()
    {
        $data = Produk::orderByDesc('created_at')->limit(6)->get([
            'id', 'harga', 'gambar', 'diskon', 'nama', 'isGrosir',
            'harga_diskon', 'harga_grosir', 'diskonGrosir', 'harga_diskon_grosir', 'sub_kategori_id'
        ])->toArray();

        $res = [];

        foreach ($data as $i => $row) {
            $ulasan = Ulasan::where('produk_id', $row['id'])->get();
            $row['count_ulasan'] = 0;
            $row['avg_ulasan'] = 0;


            foreach ($ulasan as $ls) {
                $row['count_ulasan'] = $row['count_ulasan'] + 1;
                $row['avg_ulasan'] = $row['avg_ulasan'] + $ls->bintang;
            }
            $row['avg_ulasan'] = $row['avg_ulasan'] ? $row['avg_ulasan'] / $row['count_ulasan'] : 0;
            $res[] = $row;
        }

        $data = $this->get_image_path($res);

        return $res;
    }

    public function get_popular()
    {
        $query = " select * from (SELECT p.nama,p.id,p.harga, p.gambar, p.diskon, p.harga_diskon,p.harga_grosir,p.diskonGrosir,p.isGrosir, p.harga_diskon_grosir ,p.sub_kategori_id,count(u.produk_id) as jumlah
        from produk p left join ulasans u on
                    u.produk_id = p.id group by p.id, p.harga , p.diskon, p.harga_diskon,p.harga_grosir,p.diskonGrosir, p.harga_diskon_grosir, p.gambar,p.sub_kategori_id) a order by jumlah DESC limit 6";
        $data = DB::select(DB::raw($query));
        $data = json_decode(json_encode($data), true);

        $res = [];

        foreach ($data as $i => $row) {
            $ulasan = Ulasan::where('produk_id', $row['id'])->get();
            $row['count_ulasan'] = 0;
            $row['avg_ulasan'] = 0;


            foreach ($ulasan as $ls) {
                $row['count_ulasan'] = $row['count_ulasan'] + 1;
                $row['avg_ulasan'] = $row['avg_ulasan'] + $ls->bintang;
            }
            $row['avg_ulasan'] = $row['avg_ulasan'] ? $row['avg_ulasan'] / $row['count_ulasan'] : 0;
            $res[] = $row;
        }

        $data = $this->get_image_path($res);

        return $res;
    }

    public function get_top_rated()
    {
        $data = Produk::where('stock', '>', 0)
            ->withCount(['getUlasan as average_rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg(bintang),0)'));
            }])->orderByDesc('average_rating')->take(6)->get()->toArray();
        $res = [];

        foreach ($data as $i => $row) {
            $ulasan = Ulasan::where('produk_id', $row['id'])->get();
            $row['count_ulasan'] = 0;
            $row['avg_ulasan'] = 0;


            foreach ($ulasan as $ls) {
                $row['count_ulasan'] = $row['count_ulasan'] + 1;
                $row['avg_ulasan'] = $row['avg_ulasan'] + $ls->bintang;
            }
            $row['avg_ulasan'] = $row['avg_ulasan'] ? $row['avg_ulasan'] / $row['count_ulasan'] : 0;
            $res[] = $row;
        }

        $data = $this->get_image_path($res);

        return $res;
    }

    public function get_image_path($data)
    {
        $array = [];
        foreach ($data as $datum => $key) {
            if ($key['gambar'] == "placeholder.jpg" || $key['gambar'] == "") {
                $filepath = asset('storage/produk/thumb/' . $key['gambar']);
            } else {
                $filepath = asset('storage/produk/thumb/' . $key['gambar']);
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

    public function get_voucher(Request $request)
    {
        $q = $request->q;


        try {

            $user = auth('api')->user();

            $promo = PromoCode::query()->where('promo_code', 'LIKE', "%$q%")
                ->whereDate('start', '<=', now())
                ->whereDate('end', '>=', now())
                ->whereHas('getVoucher', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->where('is_use', false)->where('used_at', null);
                })
                ->when($user, function ($q) use ($user) {
                    $voucher_digunakan = [];
                    $pesanan = Pesanan::where('user_id', $user->id)
                        ->whereNotNull('promo_code')
                        ->select('keranjang_ids', 'promo_code')
                        ->get();
                    // ->pluck('promo_code');

                    foreach ($voucher_digunakan as $t) {
                        $check_keranjang = Keranjang::whereIn('id', $t->keranjang_ids)->first();
                        if ($check_keranjang && $check_keranjang->isCheckOut) {
                            $voucher_digunakan[] = $t->promo_code;
                        }
                    }


                    return $q->whereNotIn('promo_code', $voucher_digunakan);
                })
                ->orderBy('end')
                ->get();


            $dt = [];
            foreach ($promo as $i => $row) {
                $dt[$i] = $row;
                $dt[$i]->banner = $row->banner && File::exists('storage/voucher/banner/' . $row->banner) ? asset('storage/voucher/banner/' . $row->banner) : asset('images/voucher-no-image.jpg');
            }


            return response()->json([
                'error' => false,
                'data' => [
                    'daftar' => $dt,
                    'jumlah' => count($promo)
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

    public function use_voucher(Request $request)
    {
        try {
            $data = VouucherUser::query()->where('user_id',$request->user_id)->where('voucher_id',$request->voucher_id)
                ->first();

            $data->update([
               'is_use' => true,
                'used_at' => now()
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                        'message' => 'voucher berhasil dipakai'
                ]
            ],200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ],500);
        }
    }

    public function get_detail($id)
    {
        try {

            $user = auth('api')->user();
            $check = auth()->check();

            $data = Produk::find($id);
            $ulasan = Ulasan::query()->where('produk_id', $id)->orderBy('bintang', 'desc')
                ->orderBy('created_at', 'desc')->with('getUser')->first();
            $review = [
                'data' => $ulasan,
                'count' => Ulasan::where('produk_id', $id)->count(),
                'avg' => DB::table('ulasans')->where('produk_id', $id)
                    ->avg('bintang'),
                'image' => Ulasan::where('produk_id', $id)->take(4)->get('gambar'),
                'ulasan' => Ulasan::query()->where('produk_id', $id)->with('getUser')->orderBy('bintang', 'desc')
                    ->orderBy('created_at', 'desc')->get(),

            ];

            $qna = $data->getQnA->toArray();

            // $cek_komen=Pesanan::where('user_id',$user->id)
            // ->whereNotNull('tgl_diterima')
            // ->whereNotNull('tgl_diterima')
            // ->where('keranjang_ids','like',"%$id%")->count();
            $dt = array();
            if (is_array($data->galeri)) {
                foreach ($data->galeri as $i => $row) {
                    $dt[] = $row && File::exists('storage/produk/thumb/' . $row) ?
                        asset('storage/produk/thumb/' . $row) : asset('storage/produk/galeri/' . $row);
                }
            }
            if ($gam = $data->gambar) {

                $data->gambar =
                    $gam && File::exists('storage/produk/thumb/' . $gam) ?
                        asset('storage/produk/thumb/' . $gam)
                        : asset('storage/produk/galeri/' . $gam);
                $data->galeri = count($dt) ? $dt : [$data->gambar];
            }

            $data['count_ulasan'] = 0;
            $data['avg_ulasan'] = 0;
            $data['isWished'] = $user ? Favorit::where('user_id', $user->id)->where('produk_id', $id)->count() : 0;

            foreach ($data->getUlasan as $ls) {
                $data['count_ulasan'] = $data['count_ulasan'] + 1;
                $data['avg_ulasan'] = $data['avg_ulasan'] + $ls->bintang;
            }

            $data['avg_ulasan'] = $data['avg_ulasan'] ? $data['avg_ulasan'] / $data['count_ulasan'] : 0;

            $qna = $this->get_detail_ulasan($qna);
            return response()->json([
                'error' => false,

                'data' =>

                    $this->res_get_product(
                        $data,
                        $review,
                        $qna,
                        ($user ? $user->getKeranjang->where('isCheckOut', false)->count() : 0),
                        (bool)$user
                    )
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    private function res_get_product($data, $review, $qna, $count_card, $is_login)
    {
        return [

            'detail' => $data,
            'review' => $review,
            'qna' => $qna,
            'count_cart' => $count_card,
            // 'is_login'=>$user ? true : false,
            'is_login' => $is_login
        ];
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
