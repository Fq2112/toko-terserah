<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function getSubKategori()
    {
        try {
            $data = SubKategori::query()->orderBy('nama')->get();

            return response()->json(
                [
                    'error' => false,
                    'data' => $data
                ],
                200
            );

            // $kat=Kategori::orderBy('nama','desc')->get(['id','nama'])->toArray();
            // $res=[];

            // foreach($kat as $i=>$row){
            //     $row['sub']=[];
            // $sub = SubKategori::query()->orderBy('nama')->get(['id','nama']);
            // foreach($sub as $ls){
            //     $row['sub'][]=$ls;
            // }
            // $res[]=$row;


            // }


            // return response()->json(
            //     [
            //         'error' => false,
            //         'data' => $res
            //     ],
            //     200
            // );
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
