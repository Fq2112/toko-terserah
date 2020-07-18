<?php

use Illuminate\Database\Seeder;

class UlasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Models\Pesanan::where('isLunas', true)->get() as $row) {
            $keranjang = \App\Models\Keranjang::whereIn('id', $row->keranjang_ids)->get();
            foreach ($keranjang as $val) {
                $arr = array("3.5", "4", "4.5", "5");
                \App\Models\Ulasan::create([
                    'produk_id' => $val->getProduk->id,
                    'deskripsi' => \Faker\Factory::create()->paragraph,
                    'gambar' => 'placeholder.jpg',
                    'bintang' => $arr[array_rand($arr)]
                ]);
            }
        }
    }
}
