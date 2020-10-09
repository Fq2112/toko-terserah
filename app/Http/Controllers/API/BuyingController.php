<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use App\Models\QnA;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BuyingController extends Controller
{
    private function resSuccess($wishlistt,$msg=null)
    {

        return response()->json([
            'error' => false,
            'data' => [
                'address' => $wishlistt,
                'count_address' => $this->countArray($wishlistt),
                'message'=>$msg,
            ]
        ]);
    }


    public function get()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $wishlistt= $user->getWishlist;

            return $this->resSuccess($wishlistt,'data berhasil diambil');

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
            $thumbnail = '';

            if ($request->hasFile('gambar')) {
                $this->validate($request, ['gambar' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
                $thumbnail = $request->file('gambar')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/produk/ulasan/', $thumbnail);
            }

            Ulasan::query()->create([
                'user_id' => $request->get('user_id'),
                'produk_id' => $request->get('produk_id'),
                'deskripsi' => $request->get('ulasan'),
                'gambar' => $thumbnail,
                'bintang' => $request->get('bintang')
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


}
