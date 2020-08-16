<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\Models\Setting::create([
           'email' => "",
           'address' => ' Jl. Raya Lontar No. 46 Surabaya – 60216',
           'phone' => ' +62 811-3051-081',
           'logo' => 'images/logotype.png',
           'harga_pengiriman' => '10000',
           'min_pembelian' => '200000',
       ]);
    }
}
