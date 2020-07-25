<?php

use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new \GuzzleHttp\Client();

        foreach (\App\Models\Kota::all() as $row) {
            $response = $client->request('GET', env('RajaOngkir_URL') . '/subdistrict?city=' . $row->id, [
                'headers' => [
                    'Accept' => 'application/json',
                    'key' => env('RajaOngkir_KEY')
                ],
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            foreach ($data['rajaongkir']['results'] as $datum) {
                \App\Models\Kecamatan::create([
                    'kota_id' => $datum['city_id'],
                    'nama' => $datum['subdistrict_name'],
                ]);
            }
        }
    }
}
