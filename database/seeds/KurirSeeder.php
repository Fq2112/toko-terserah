<?php

use Illuminate\Database\Seeder;

class KurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Kurir::create([
            'kode' => 'JNE',
            'nama' => 'Jalur Nugraha Ekakurir',
            'logo' => 'jne.png',
        ]);

        \App\Models\Kurir::create([
            'kode' => 'POS',
            'nama' => 'POS Indonesia',
            'logo' => 'pos.png',
        ]);

        \App\Models\Kurir::create([
            'kode' => 'TIKI',
            'nama' => 'Citra Van Titipan Kilat',
            'logo' => 'tiki.png',
        ]);

        \App\Models\Kurir::create([
            'kode' => 'SICEPAT',
            'nama' => 'SiCepat Express',
            'logo' => 'sicepat.png',
        ]);

        \App\Models\Kurir::create([
            'kode' => 'J&T',
            'nama' => 'J&T Express',
            'logo' => 'jnt.png',
        ]);
    }
}
