<?php

use Illuminate\Database\Seeder;

class SubKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub[] = [
            'Makanan Instan Siap Santap',
            'Bahan Pembuat Kue',
            'Kue',
            'Garam & Bumbu Dapur',
            'Mie & Bihun',
            'Makanan Kering',
            'Minyak',
            'Makanan Kaleng',
            'Pasta',
        ];

        $sub[] = [
            'UHT, Susu & Susu Bubuk',
            'Kopi',
            'Minuman Serbuk',
            'Minuman Berenergi',
            'Teh',
            'Chocolate, Malt',
            'Air Mineral',
            'Minuman Berkarbonasi',
            'Jus',
            'Sirup',
        ];

        $sub[] = [
            'Camilan',
            'Coklat',
            'Biskuit dan Kerupuk',
            'Permen',
        ];

        $sub[] = [
            'Selai',
            'Oatmeal',
            'Sereal dan Sarapan',
            'Tepung Pancake',
            'Bars',
        ];

        $sub[] = [
            'Buah Segar',
            'sayur Segar',
        ];


        $sub[] = [
            'Pengharum Ruangan',
            'Kebutuhan Kebersihan',
            'Pengendalian Hama',
            'Sabun Pencuci Piring',
            'Kebutuhan Laundry',
        ];

        $sub[] = [
            'Makanan dan Camilan Kucing',
            'Makanan Burung',
            'Makanan Ikan',
            'Makanan Camilan Anjing',

        ];

        $sub[] = [
            'Kebutuhan Akuarium',
            'Kandang & Aksesoris',
            'Peralatan Grooming',
        ];

        $sub[] = [
            'Perawatan Gigi',
            'Pembasmi Kutu',
        ];

        for ($i = 0; $i < count($sub); $i++) {
            foreach ($sub[$i] as $subs) {
                \App\Models\SubKategori::create([
                    'kategori_id' => $i + 1,
                    'nama' => $subs,
                    'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($subs))
                ]);
            }
        }
    }
}
