<?php

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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
        $keranjang = \App\Models\Keranjang::where('user_id', $user->id)->where('isCheckOut', true)->inRandomOrder()->get();

        foreach ($keranjang->chunk(3) as $three) {
            $code = strtoupper(uniqid('PYM') . now()->subDays(rand(1, 3))->timestamp);
            $cek = rand(0, 1) ? true : false;
            $cek2 = rand(0, 1) ? false : true;

            $data = \App\Models\Pesanan::create([
                'user_id' => $user->id,
                'keranjang_ids' => $three->pluck('id'),
                'pengiriman_id' => $alamat->id,
                'penagihan_id' => $alamat_utama->id,
                'uni_code' => $code,
                'ongkir' => 10000,
                'durasi_pengiriman' => '1-3',
                'berat_barang' => $three->sum('berat'),
                'total_harga' => $three->sum('total'),
                'note' => \Faker\Factory::create()->paragraph,
                'isLunas' => $cek,
                'kode_kurir' => 'jne',
                'nama_kurir' => 'Jalur Nugraha Ekakurir (JNE)',
                'layanan_kurir' => 'CTCYES',
                'resi' => $cek == true && $cek2 == true ? '030370046239120' : null,
                'tgl_pengiriman' => $cek == true && $cek2 == true ? now()->subDays(3) : null,
                'tgl_diterima' => null,
            ]);

            $arr = ['bca', 'bni', 'mandiri', 'permata'];
            $payment = [
                'type' => 'bank_transfer',
                'bank' => $arr[array_rand($arr)],
                'account' => \Faker\Factory::create()->bankAccountNumber,
            ];

            $pdf = PDF::loadView('exports.invoice', compact('code', 'data', 'payment'));
            Storage::put('public/users/invoice/' . $user->id . '/' . $code . '.pdf', $pdf->output());
        }
    }
}
