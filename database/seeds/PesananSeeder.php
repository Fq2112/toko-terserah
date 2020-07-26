<?php

use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::find(1);
        $alamat_utama = \App\Models\Alamat::where('user_id', $user->id)->where('isUtama', true)->first();
        $alamat = \App\Models\Alamat::where('user_id', $user->id)->where('isUtama', false)->first();
        $keranjang = \App\Models\Keranjang::where('isCheckOut', true)->inRandomOrder()->get();

        \App\Models\Pesanan::create([
            'user_id' => $user->id,
            'keranjang_ids' => $keranjang->pluck('id'),
            'pengiriman_id' => $alamat->id,
            'penagihan_id' => $alamat_utama->id,
            'uni_code' => uniqid('PYM') . now()->timestamp,
            'ongkir' => 10000,
            'durasi_pengiriman' => '1-3',
            'berat_barang' => $keranjang->sum('berat'),
            'total_harga' => $keranjang->sum('total'),
            'note' => \Faker\Factory::create()->paragraph,
            'isLunas' => true,
            'kode_kurir' => 'jne',
            'nama_kurir' => 'Jalur Nugraha Ekakurir (JNE)',
            'layanan_kurir' => 'CTCYES',
            'resi' => uniqid('AWB'),
            'tgl_pengiriman' => now()->subDays(3),
            'tgl_diterima' => now(),
        ]);
    }
}
