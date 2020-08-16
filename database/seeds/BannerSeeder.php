<?php

use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 5; $i++) {
            \App\Models\Banner::create([
                'banner' => $i . '.png',
                'produk' => $i,
                'urutan' => $i
            ]);
        }
    }
}
