<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;

class keranjangController extends Controller
{
    public function get()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $data = Keranjang::where('user_id', $user->id)
                ->where('isCheckOut', false)
                ->get();

            foreach ($data as $row) {
                $row->getProduk->select('id');
            }

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

    public function moveWishlist(Request $request)
    {
        # code...
    }

    public function addCart(Request $request)
    {
        // return json_encode($request->qty);
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            if ($cek = DB::table('keranjang')->where('produk_id', $request->id)->where('user_id',  $user->id)->first()) {
                $request->id = $cek->id;
                $request->qty = $request->qty + $cek->qty;
                return $this->updateCart($request);
            } else {
                DB::beginTransaction();


                $produk = DB::table('produk')->where('id', $request->id)->first();


                if ($produk->isGrosir == true) {
                    $harga = $produk->isDiskonGrosir == true ? $produk->harga_diskon_grosir : $produk->harga_grosir;
                    $min_qty = $produk->min_qty;
                } else {
                    $harga = $produk->is_diskon == true ? $produk->harga_diskon : $produk->harga;
                    $min_qty = 1;
                }
                $qty = $request->qty >= $min_qty ? $request->qty : $min_qty;

                if ($qty > $produk->stock) {
                    return response()->json(
                        [
                            'error' => true,
                            'data' => [
                                'stok' => $produk->stock,
                                'qty' => $qty,
                                'message' => 'Stock kurang',
                            ]
                        ],
                        400
                    );
                }

                Keranjang::insert([
                    'user_id' => $user->id,
                    'produk_id' => $produk->id,
                    'berat' => $produk->berat * $qty,
                    'qty' => $qty,
                    'total' => $harga * $qty
                ]);

                DB::table('produk')->where('id', $request->id)->update(
                    [
                        'stock' => $produk->stock - $qty,
                    ]
                );

                //save in table 2

                //save in table 3....with a sql error
                DB::commit();

                return response()->json(
                    [
                        'error' => false,
                        'data' => [

                            'qty' => $qty,
                            'message' => 'berhasil ditambah ' . $qty
                        ]
                    ],
                    201
                );
            }
        } catch (Exception $e) {
            DB::rollback(); //if rollback due to error occurs in query 3 then no data will be saved in table 1 and 2...Not Mandatory

            return response()->json(
                [
                    'error' => true,
                    'data' => [

                        'message' => $e,
                    ]
                ],
                400
            );
        }
    }

    public function updateCart(Request $request)
    {
        DB::beginTransaction();
        try {
            // if (!$user = JWTAuth::parseToken()->authenticate()) {
            //     return response()->json(['user_not_found'], 404);
            // }
            $cart = Keranjang::where('id', $request->id)->first();
            $produk = $cart->getProduk;
            $qty_recent = $cart->qty;


            if ($produk->isGrosir == true) {
                $harga = $produk->isDiskonGrosir == true ? $produk->harga_diskon_grosir : $produk->harga_grosir;
                $min_qty = $produk->min_qty;
            } else {
                $harga = $produk->is_diskon == true ? $produk->harga_diskon : $produk->harga;
                $min_qty = 1;
            }



            $qty = $request->qty >= $min_qty ? $request->qty : $min_qty;
            // return  $qty_recent.'   '.$qty;



            if ($qty_recent > $qty) {
                $qty_re = ($qty_recent - $qty) * -1;
            } elseif ($qty_recent == $qty) {
                $qty_re = 0;
            } else {
                $qty_re = $qty - $qty_recent;
            }

            if ($qty > $produk->stock) {
                return response()->json(
                    [
                        'error' => true,
                        'data' => [
                            'stok' => $produk->stock,
                            'qty' => $qty - $qty_recent,
                            'message' => 'Stock kurang',
                        ]
                    ],
                    400
                );
            }

            $cart->update([

                'berat' => $produk->berat * $qty,
                'qty' => $qty,
                'total' => $harga * $qty
            ]);

            $produk->update([
                'stock' => $produk->stock - $qty_re
            ]);


            //save in table 2

            //save in table 3....with a sql error
            DB::commit();
            return response()->json(
                [
                    'error' => false,
                    'data' => [

                        'qty' => $qty,
                        'message' => 'berhasil ' . $produk->nama . ' diubah ' . $qty
                    ]
                ],
                200
            );
        } catch (Exception $e) {

            DB::rollback();
            return response()->json(
                [
                    'error' => true,
                    'data' => [

                        'message' => $e
                    ]
                ],
                400
            );
        }
    }
}