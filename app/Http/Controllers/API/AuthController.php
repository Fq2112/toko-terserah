<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Auth\ActivationMail;
use App\Models\Bio;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
            }else{
                return response()->json(['error' => 'Silahkan aktivasi akun anda'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(compact('token'));
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

        Bio::create(['user_id' => $user->id]);
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
            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $user,
                    'bio' => $user->getBio,
                    'address' => $user->getAlamat,
                    'count_wish' => count($user->getWishlist),
                    'count_cart' => count($user->getKeranjang)
                ]
            ]);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }


    }

    public function check_email(Request $request){
        $res=[
            'error'=>true,
        ];
        $status=404;
        $v = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";



        try{
            if($request->has('email')){

                $email=$request->email;
                $jumlahUser=User::where('email',$email)->count();
                if(!(bool)preg_match($v, $email)){
                    $res['data']=['message'=>'gunakan email yang valid'];
                }
                elseif($jumlahUser){

                    $res['data']=['message'=>'email sudah digunakan'];

                }else{
                    $res['error']=false;
                    $res['data']=['message'=>'email dapat digunakan'];
                    $status=200;
                }
            }else{

                $res['data']=['message'=>'email kosong'];
            }

            return response()->json($res,$status);


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
