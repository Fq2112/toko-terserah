<?php

use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produk = \App\Models\Produk::where('stock', '>', 0)->orderByDesc('id')->get();

        foreach ($produk->chunk(5) as $five) {
            foreach ($five as $row) {
                $qty = rand(1, 10);
                $harga = $row->is_diskon == true ? $row->harga_diskon : $row->harga;

                \App\Models\Keranjang::create([
                    'user_id' => rand(\App\User::min('id'), \App\User::max('id')),
                    'produk_id' => $row->id,
                    'qty' => $qty,
                    'berat' => $qty * $row->berat,
                    'total' => $qty * $harga,
                    'isCheckOut' => rand(0, 1) ? true : false,
                ]);

                \App\Models\Favorit::create([
                    'user_id' => rand(\App\User::min('id'), \App\User::max('id')),
                    'produk_id' => $row->id,
                ]);
            }
        }
    }
}
