<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\QnA;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BuyingController extends Controller
{
    private function resSuccess($wishlistt, $msg = null)
    {

        return response()->json([
            'error' => false,
            'data' => [
                'data' => $wishlistt,
                'count' => count($wishlistt),
                'message' => $msg,
            ]
        ]);
    }


    public function get_wish(Request $request)
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $q = $request->get('q');
            $wishlistt = Favorit::where('user_id', $user->id)->whereHas('getProduk', function ($query) use ($q) {
                $query->where('nama', 'like', "%$q%");
            })->get();

            foreach ($wishlistt as $row) {
                $row['count_ulasan'] = 0;
                $row['avg_ulasan'] = 0;

                foreach ($row->getProduk->getUlasan as $ls) {
                    $row['count_ulasan'] = $row['count_ulasan'] + 1;
                    $row['avg_ulasan'] = $row['avg_ulasan'] + $ls->bintang;
                }

                $row['avg_ulasan'] = $row['avg_ulasan'] ? $row['avg_ulasan'] / $row['count_ulasan'] : 0;
            }

            return $this->resSuccess($wishlistt, 'data berhasil diambil');
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function add_wish_list(Request $request)
    {
        try {
            $data = Favorit::create([
                'user_id' => $request->get('user_id'),
                'produk_id' => $request->get('produk_id')
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Menambahkan Wishlist'
                ]
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function delete_wish_list($id)
    {
        try {
            $wish = Favorit::find($id)->delete();
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Menghapus Wishlist'
                ]
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function switchWish(Request $request)
    {
        $id = $request->id;


        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $cek = Favorit::where('user_id', $user->id)
                ->where('produk_id', $id)
                ->first();

            if ($cek) {
                $cek->delete();
                $status = false;
            } else {
                Favorit::create([
                    'user_id' => $user->id,
                    'produk_id' => $id,
                ]);
                $status = true;
            }


            return response()->json(
                [
                    'error' => false,
                    'data' => [

                        'status_wished' => $status,
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

    public function mass_delete_wish_list(Request $request)
    {
        try {
            foreach ($request->get('ids') as $id) {
                $wish = Favorit::find($id);
                $wish->delete();
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Menghapus Wishlist'
                ]
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function submit_qna(Request $request)
    {
        try {
            QnA::query()->create([
                'user_id' => $request->get('user_id'),
                'produk_id' => $request->get('produk_id'),
                'tanya' => $request->get('tanya')
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Silahkan Tunggu Responnya Sob'
                ]
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }


    public function submit_ulasan(Request $request)
    {
        try {
            foreach (json_decode($request->get('produk_ids'),true) as $item) {
                Ulasan::query()->create([
                    'user_id' => $request->get('user_id'),
                    'produk_id' => $item,
                    'deskripsi' => $request->get('ulasan'),
                    'gambar' => $request->get('gambar'),
                    'bintang' => $request->get('bintang')
                ]);
            }

            $pesanan = Pesanan::query()->where('uni_code',$request->get('uni_code'))->first();

            $pesanan->update([
                'is_reviewed' => true
            ]);
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Terima kasih telah berbelanja di Toko Terserah'
                ]
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function _ulasan_image(Request $request)
    {
        try {
            if ($request->hasFile('gambar')) {
                $this->validate($request, ['gambar' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
                $thumbnail = $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->storeAs('public/produk/ulasan/', $thumbnail);
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Upload File'
                ]
            ], 200);
        }
        catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }
}
