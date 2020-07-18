<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    const ProdukArray = [
        'Happy Tos Merah',
        'Happy Tos Hijau',
        'Happy Tos Roasted Corn',
        'Happy Tos Nacho Cheese',
        'Happy Tos SeaWeed',
        'Happy Tos Roasted Corn 150 Gr',
    ];

    public function run()
    {
        $faker = Factory::create('id_ID');
        foreach (static::ProdukArray as $item) {
            $cek = rand(0, 1) ? true : false;

            \App\Models\Produk::create([
                'nama' => $item,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($item)),
                'gambar' => 'placeholder.jpg',
                'kode_barang' => 'HT' . $faker->numerify('###'),
                'berat' => rand(50, 150),
                'stock' => rand(0, 10),
                'deskripsi' => $faker->paragraph,
                'warna' => 'Merah',
                'barcode' => $faker->numerify('#######'),
                'sub_kategori_id' => rand(\App\Models\SubKategori::min('id'), \App\Models\SubKategori::max('id')),
                'harga' => abs(round((rand(1000, 100000) + 500), -3)),
                'is_diskon' => $cek,
                'diskon' => $cek == true ? rand(10, 50) : null
            ]);
        }

        $a = 1;
        for ($i = 0; $i < 50; $i++) {
            $cek = rand(0, 1) ? true : false;
            $name = ucwords($faker->words(rand(2, 4), true)) . ' ' . $a++;

            \App\Models\Produk::create([
                'nama' => $name,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($name)),
                'gambar' => 'placeholder.jpg',
                'kode_barang' => substr($name, 0, 1) . $faker->numerify('###'),
                'berat' => rand(50, 150),
                'stock' => rand(0, 10),
                'deskripsi' => $faker->paragraph,
                'warna' => 'Merah',
                'barcode' => $faker->numerify('#######'),
                'sub_kategori_id' => rand(\App\Models\SubKategori::min('id'), \App\Models\SubKategori::max('id')),
                'harga' => abs(round((rand(1000, 100000) + 500), -3)),
                'is_diskon' => $cek,
                'diskon' => $cek == true ? rand(10, 50) : null
            ]);
        }
    }
}
