<?php

use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('RajaOngkir_URL') . '/province', [
            'headers' => [
                'Accept' => 'application/json',
                'key' => env('RajaOngkir_KEY')
            ],
        ]);
        $data =  json_decode($response->getBody()->getContents(),true);

        foreach ($data['rajaongkir']['results'] as $datum){
            \App\Models\Provinsi::create([
                'nama' => $datum['province']
            ]);
        }
    }
}
