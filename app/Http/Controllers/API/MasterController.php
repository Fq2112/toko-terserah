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
