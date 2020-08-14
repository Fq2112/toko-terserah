<?php

use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    CONST QUESTION = [
        'Permisi, Apakah Barang Ready ?',
        'Apakah Barang Bisa Dikirm Hari ini ?',
        'Apakah Ada Toko Offline ?'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::QUESTION as $item){
            \App\Models\Template::create([
                'pertanyaan' => $item
            ]);
        }
    }
}
