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
            \App\Models\Produk::create([
                'nama' => $item,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($item)),
                'gambar' => $faker->imageUrl('https://picsum.photos/200/300'),
                'kode_barang' => 'HT' . $faker->numerify('###'),
                'berat' => rand(50, 150),
                'stock' => rand(10, 100),
                'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'warna' => 'Merah',
                'barcode' => $faker->numerify('#######'),
                'sub_kategori_id' => rand(\App\Models\SubKategori::min('id'), \App\Models\SubKategori::max('id')),
                'harga' => rand(1000, 100000)
            ]);
        }
    }
}
