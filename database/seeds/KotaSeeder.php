<?php

use Illuminate\Database\Seeder;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('RajaOngkir_URL') . '/city', [
            'headers' => [
                'Accept' => 'application/json',
                'key' => env('RajaOngkir_KEY')
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        foreach ($data['rajaongkir']['results'] as $datum) {
            \App\Models\Kota::create([
                'provinsi_id' => $datum['province_id'],
                'nama' => $datum['city_name'],
                'tipe' => $datum['type'],
                'kode_pos' => $datum['postal_code']
            ]);
        }
    }
}
