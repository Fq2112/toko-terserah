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
        foreach (\App\Models\Produk::all() as $row) {
            $qty = rand(1, 10);
            \App\Models\Keranjang::create([
                'user_id' => rand(\App\User::min('id'), \App\User::max('id')),
                'produk_id' => $row->id,
                'qty' => $qty,
                'berat' => $qty * $row->berat,
                'total' => $qty * $row->harga,
                'isCheckOut' => rand(0, 1) ? true : false,
            ]);
        }
    }
}
