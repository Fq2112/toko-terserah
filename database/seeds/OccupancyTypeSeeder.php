<?php

use Illuminate\Database\Seeder;

class OccupancyTypeSeeder extends Seeder
{
    const NAME = [
        "Apartemen",
        "Hotel",
        "Kantor",
        "Kondominium",
        "Kontrakan",
        "Kosan",
        "Rumah",
        "Rumah Kantor",
        "Rumah Susun",
        "Rumah Toko",
    ];

    public function run()
    {
        foreach (self::NAME as $item) {
            \App\Models\OccupancyType::create([
                'name' => $item,
                'image' => preg_replace("![^a-z0-9]+!i", "-", strtolower($item)) . '.png',
            ]);
        }
    }
}
