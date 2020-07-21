<?php

use Illuminate\Database\Seeder;

class QnAseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Models\Produk::where('stock', '>', 0)->get() as $produk) {
            foreach (\App\User::all() as $user) {
                \App\Models\QnA::create([
                    'user_id' => $user->id,
                    'produk_id' => $produk->id,
                    'tanya' => str_replace('.', '?', \Faker\Factory::create()->sentence),
                    'jawab' => \Faker\Factory::create()->paragraph,
                ]);
            }
        }
    }
}
