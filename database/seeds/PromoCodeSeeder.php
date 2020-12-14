<?php

use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 5; $i++) {
            \App\Models\PromoCode::create([
                'promo_code' => strtoupper(uniqid('PRM')),
                'start' => now(),
                'end' => now()->addMonth(),
                'description' => \Faker\Factory::create()->sentence,
                'discount' => \Faker\Factory::create()->numerify('#####'),
                'minim_beli' => \Faker\Factory::create()->numerify('#####')
            ]);
        }

        \App\Models\PromoCode::find(1)->update(['promo_code' => 'terserahanda']);
    }
}
