<?php

use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const KategoriArray = [
        'Minuman',
        'Bahan & Bumbu Masak',
        'Cokelat, Camilan & Permen',
        'Makanan Sarapan, Sereal & Selai',
        'Buah & Sayur',
        'Kebutuhan Rumah Tangga',
        'Makanan Hewan Peliharaan',
        'Aksesoris Hewan Peliharaan',
        'Kesehatan Hewan Peliharaan',

    ];

    public function run()
    {
        foreach (static::KategoriArray as $kategori) {
            \App\Models\Kategori::create([
                'nama' => $kategori,
                'thumb' => 'placeholder.jpg',
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($kategori))
            ]);
        }
    }
}
