<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use Illuminate\Http\Request;

class BuyingController extends Controller
{
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
}
