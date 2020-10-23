<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Alamat;
use App\Models\Kota;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class alamatController extends Controller
{

    public function get(){
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $alamat= $user->getAlamat;

            foreach($alamat as $row){
                $row->getOccupancy;
                $row->getKecamatan;
                $row->getKecamatan->getKota;
                $row->getKecamatan->getKota->getProvinsi;

            }

            return $this->resSuccess($alamat,'data berhasil diambil');

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }


    public function set_utama(Request $request)
    {
        // return $request->id;
        DB::beginTransaction();
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $alamat=$user->getAlamat;

            foreach($alamat as $row){
                $row->update(['isUtama'=>($request->id==$row->id ? 1: 0)]);
                if($request->id==$row->id){

                }
            }

            DB::commit();
            return response()->json(
                [
                    'error' => false,
                    'data' => [


                        'message' => 'berhasil   diubah '
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
    public function detail(Request $request){
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $res=$user->getAlamat->where('id',$request->id);

            if($res){
                $res=$res->first();

//                $res->occupancy_id=DB::table('occupancy_types')
//                        ->select('id','name','image',DB::raw('CONCAT("'.asset('images/icons/occupancy').'/",image) AS image'))->first();


                $other_link=DB::table('kecamatan as a')
                ->join('kota as b','a.kota_id','=','b.id')
                ->join('provinsi as c','b.provinsi_id','=','c.id')

                                ->select('a.id as kecamatan_id','a.nama as kecamatan_name','b.id as kota_id','b.nama as kota_name','b.provinsi_id','c.nama as provinsi_name')
                                ->where('a.id','=',"$res->kecamatan_id")->first();


                foreach($other_link as $row){
                    foreach($other_link as $i=>$col){
                        // return $i;
                    $res->{$i}=$col;
                    }
                }

            return response()->json([
                'error' => false,
                'data' =>  $res
            ]);
            }
            else{
                return $this->resNotFound();
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }


    public function create(Request $request){


        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $validator = $this->validateForm($request);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' => $validator->errors()->toJson()
                    ]
                ], 400);
            }

             Alamat::create($this->setRequest($request,$user));

             $alamat=$user->getAlamat;


             return $this->resSuccess($alamat,'data berhasil dibuat');

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());


        }
    }

    public function update(Request $request){
        $id=$request->id;

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $validator = $this->validateForm($request);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' => $validator->errors()->toJson()
                    ]
                ], 400);
            }

            $alamatEdit= Alamat::find($id);

             if($alamatEdit && $user->getAlamat->where('id',$id)){
                $alamatEdit->update($this->setRequest($request,$user));

                $alamat=User::where('id',$user->id)->first()->getAlamat;

                return $this->resSuccess($alamat,'data berhasil diubah');

             }

             return $this->resNotFound();




            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());


        }
    }

    public function delete(Request $request){
        $id=$request->id;

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            /*$validator = $this->validateForm($request);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' => $validator->errors()->toJson()
                    ]
                ], 400);
            }*/

            if($user->getAlamat->where('id',$id)){
                Alamat::destroy($id);
                $alamat=User::where('id',$user->id)->first()->getAlamat;

                return $this->resSuccess($alamat,'data berhasil dihapus');
            }

            return $this->resNotFound();



        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());


        }
    }

    public function get_kota(Request $request){
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $q=$request->get('q');
            $pro_id=$request->get('provinsi_id');

            $kota=DB::table('kota as k')->join('provinsi as p', 'k.provinsi_id', '=', 'p.id')
            ->select('k.id as kota_id','k.nama','p.nama as provinsi','k.kode_pos','k.tipe')
            ->where('k.nama','like',"%$q%")

            ->orderBy('k.nama','asc')
            ->where('k.provinsi_id','=',"$pro_id")
            ->get();
            $not_found=$this->countArray($kota);

            return response()->json([
                "error"=>false,
                "data"=>[
                    "city"=>$kota,
                ] ]);



        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }

    public function get_occupancy(Request $request){
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $q=$request->get('q');

            $kota=DB::table('occupancy_types')
                ->select('id','name','image',DB::raw('CONCAT("'.asset('images/icons/occupancy').'/",image) AS image'))
                ->where('name','like',"%$q%")
                ->get();
            $not_found=$this->countArray($kota);

            return response()->json([
                "error"=>false,
                "data"=>[
                    "city"=>$kota,
                ] ]);



        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }

    public function get_kecamatan(Request $request){
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $q=$request->get('q');
            $id=$request->get('kota_id');

            $kecamatan=DB::table('kecamatan')
            ->select('id','nama')
            ->where('nama','like',"%$q%")
            ->where('kota_id','=',"$id")
            ->orderBy('nama','asc')

            ->get();
            $not_found=$this->countArray($kecamatan);

            return response()->json([
                "error"=>false,
                "data"=>[
                    "district"=>$kecamatan,
                ] ]);



        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }
    public function get_provinsi(Request $request){
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $q=$request->get('q');
            // $id=$request->get('kota_id');

            $kecamatan=DB::table('provinsi')
            ->select('id','nama')
            ->where('nama','like',"%$q%")
            ->orderBy('nama','asc')

            // ->where('kota_id','=',"$id")
            ->get();
            $not_found=$this->countArray($kecamatan);

            return response()->json([
                "error"=>false,
                "data"=>[
                    "province"=>$kecamatan,
                ] ]);



        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }

    private function countArray($model){
        return count(!is_null($model) ? $model : []);
    }

    private function resNotFound(){
         return response()->json([
            'error' => true,
            'data' => [
            'message' => "data tidak ditemukan"
            ]], 404);
    }

    private function resSuccess($alamat,$msg=null)
    {

        return response()->json([
            'error' => false,
            'data' => [
                'address' => $alamat,
                'count_address' => $this->countArray($alamat),
                'message'=>$msg,
            ]
        ]);
    }

    private function setRequest($request,$user){
        $lat=$request->get('lat');
        $long=$request->get('long');
        $send=[
            'user_id' => $user->id,
            'nama' => $request->get('nama'),
            'telp' => $request->get('telp'),
            'alamat' => $request->get('alamat'),
            'kode_pos'=>$request->get('kode_pos'),
            'occupancy_id'=>$request->get('occupancy_id'),
            'kecamatan_id'=>$request->get('kecamatan_id'),
         ];

         if($lat || $long){
            $send['lat']=$lat;
            $send['long']=$long;

         }
        return $send;
    }

    private function validateForm($request){
        return Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',

            'kode_pos'=>'required|integer|max:999999',
            'occupancy_id'=>'required|integer|max:9999',
            'kecamatan_id'=>'required|integer|max:99999',
        ]);
    }



}
