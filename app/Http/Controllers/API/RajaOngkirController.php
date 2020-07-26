<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
    public function getSubdistrict(Request $request)
    {
        $kecamatan = Kecamatan::where('kota_id', $request->city)->with('getKota')->get();

        return $kecamatan;
    }

    public function getCost(Request $request)
    {
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'application/json',
                'key' => env('RajaOngkir_KEY')
            ],
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        try {
            $response = $client->post(env('RajaOngkir_URL') . '/cost', [
                'form_params' => [
                    'origin' => 6149,
                    'originType' => 'subdistrict',
                    'destination' => $request->destination,
                    'destinationType' => 'subdistrict',
                    'weight' => $request->weight,
                    'courier' => 'jne:pos:tiki'
                ]
            ])->getBody()->getContents();

            return json_decode($response, true);

        } catch (ConnectException $e) {
            return response()->json();
        }
    }
}
