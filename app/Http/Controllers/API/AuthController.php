<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Auth\ActivationMail;
use App\Models\Bio;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\SocialProvider;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            $user = User::where('email', $request->email)->firstOrFail();

            if ($user->status != 0) {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 404);
                }
            } else {
                return response()->json(['error' => 'Silahkan aktivasi akun anda'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(compact('token'));
    }

    public function login_email(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'error' => false,
                'data' => [
                    'token' => auth('api')->login($user)
                ]
            ]);
        } else {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => 'tidak ditemukan!'
                ]
            ], 400);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $validator->errors()->toJson()
                ]
            ], 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'status' => false,
            'verifyToken' => Str::random(255),
        ]);

        Bio::create([
            'user_id' => $user->id,
            'gender' => $request->get('gender'),
            'dob' => Carbon::parse($request->get('dob'))
        ]);
        Mail::to($user->email)->send(new ActivationMail($user));
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $cek = Pesanan::where('user_id', $user->id)->where('isLunas', false)->whereNull('tgl_pengiriman')->whereNull('tgl_diterima')->first();
            if ($cek) {
                $carts = Keranjang::whereIn('id', $cek->keranjang_ids)->count();
                $carts_checkout = Keranjang::whereIn('id', $cek->keranjang_ids)->where('isCheckout', true)->count();
            }

            $res = [
                'user' => $user,
                'bio' => $user->getBio,
                'address' => $user->getAlamat,
                // "wishlist" => $user->getWishlist,
                'count_wish' => count($user->getWishlist),
                'count_cart' => $user->getKeranjang->where('isCheckOut', false)->count(),
                'count_status' => [
                    'belum_bayar' => $cek ? ($carts == $carts_checkout ? 1 : 0) : 0,
                    'dikemas_diambil' => Pesanan::where('user_id', $user->id)->where('isLunas', true)->whereNull('tgl_pengiriman')->whereNull('tgl_diterima')->count(),
                    'dikirim' => Pesanan::where('user_id', $user->id)->where('isLunas', true)->whereNotNull('tgl_pengiriman')->whereNull('tgl_diterima')->count(),
                    'selesai' => Pesanan::where('user_id', $user->id)->where('isLunas', true)->whereNotNull('tgl_diterima')->count()
                ],
            ];

            foreach ($res['address'] as $row) {
                $row->getOccupancy;
            }

            // foreach ($res['wishlist']  as $row) {
            //     $row->getProduk;
            //     $row['count_ulasan'] = 0;
            //     $row['avg_ulasan'] = 0;

            //     foreach ($row->getProduk->getUlasan as $ls) {
            //         $row['count_ulasan']=$row['count_ulasan']+1;
            //         $row['avg_ulasan'] = $row['avg_ulasan']+$ls->bintang;
            //     }

            //     $row['avg_ulasan'] = $row['avg_ulasan'] ? $row['avg_ulasan']/$row['count_ulasan']:0;
            // }


            return response()->json([
                'error' => false,
                'data' => $res
            ]);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function check_email(Request $request)
    {
        $res = [
            'error' => true,
        ];
        $status = 404;
        $v = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";

        try {
            if ($request->has('email')) {

                $email = $request->email;
                $jumlahUser = User::where('email', $email)->count();
                if (!(bool)preg_match($v, $email)) {
                    $res['data'] = ['message' => 'gunakan email yang valid'];
                } elseif ($jumlahUser) {

                    $res['data'] = ['message' => 'email sudah digunakan'];
                } else {
                    $res['error'] = false;
                    $res['data'] = ['message' => 'email dapat digunakan'];
                    $status = 200;
                }
            } else {

                $res['data'] = ['message' => 'email kosong'];
            }

            return response()->json($res, $status);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function sendParams()
    {
        try {
            $path = 'login_log/kode_login' . now()->format('Y_m_d') . '.json';
            $kode = bcrypt(now() . rand(0, 999));

            $array = Storage::disk('local')->exists($path) ?
                json_decode(Storage::disk('local')->get($path), true) : [];


            $array[] = ['kode' => $kode, 'used_at' => null, 'created_at' => now()];

            Storage::delete('login_log/kode_login' . now()->subDay() . '.json');
            Storage::put('login_log/kode_login' . now()->format('Y_m_d') . '.json', json_encode($array));

            return response()->json(['error'=>false,'token'=>$kode]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ],500);
        }
    }

    public function sosialite(Request $r)
    {
        try {
            $res = [];
            $status = 201;
            $path = 'login_log/kode_login' . now()->format('Y_m_d') . '.json';

            $array = Storage::disk('local')->exists($path) ?
                json_decode(Storage::disk('local')->get($path), true) : [];

            $kode = array_column($array, 'kode');

            $index = array_search($r->header('token'), $kode);

            if ($index >= 0 && is_null($array[$index]['used_at'])) {

                //token used
                $array[$index]['used_at'] = now();
                Storage::put('login_log/kode_login' . now()->format('Y_m_d') . '.json', json_encode($array));

                $user=User::where('email',$r->email)->first();

                if(!$user){
                    Storage::disk('local')
                    ->put('public/users/ava/' . $r->id . ".jpg", file_get_contents($r->ava));

                    $user = User::firstOrCreate([
                        'email' => $r->email,
                        'name' => $r->name,
                        'username' => strtok($r->email, '@').rand(0,9),
                        'password' => bcrypt('secret'),
                        'status' => true,
                    ]);

                    Bio::create(['user_id' => $user->id, 'ava' => $r->id . ".jpg"]);

                SocialProvider::create([
                    'user_id' => $user->id,
                    'provider_id' =>  $r->id ,
                    'provider' => 'google'
                ]);
                }

                if ($user->getBio->ava == "") {
                    Storage::disk('local')
                        ->put('public/users/ava/' . $r->id . ".jpg", file_get_contents($r->ava));

                    $user->getBio->update(['ava' => $r->id . ".jpg"]);
                }

                $res = [
                    'error' => false, 'token' => auth('api')->login($user),
                ];
            } else {
                $status = 401;
                $res = [
                    'error' => true, 'message' => 'token invalid',
                ];
            }

            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
