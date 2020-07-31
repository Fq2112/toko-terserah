<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        \App\Models\Admin::create([
            'name' => 'Fiqy Ainuzzaqy',
            'username' => 'fq_whysoserious',
            'email' => 'fiqy_a@icloud.com',
            'password' => bcrypt('Fiqy2112'),
            'role' => \App\Support\Role::ROOT,
            'facebook' => 'FqNkk',
            'twitter' => 'Fq2112',
            'instagram' => 'fq_whysoserious',
            'whatsapp' => '+6281356598237',
        ]);

        \App\Models\Admin::create([
            'name' => 'Vincent Chang',
            'username' => 'vincent_chang',
            'email' => 'vincent.chang@terserah.com',
            'password' => bcrypt('Vincent2112'),
            'role' => \App\Support\Role::OWNER,
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'whatsapp' => '',
        ]);

        \App\Models\Admin::create([
            'name' => 'Admin Terserah',
            'username' => 'admin_terserah',
            'email' => 'admin@terserah.com',
            'password' => bcrypt('admin2112'),
            'role' => \App\Support\Role::ADMIN,
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'whatsapp' => '+',
        ]);


        $user = \App\User::create([
            'name' => 'Fiqy Ainuzzaqy',
            'username' => 'jQuinn',
            'email' => 'fiqy_a@icloud.com',
            'password' => bcrypt('secret'),
            'status' => true,
        ]);
        \App\Models\Bio::create([
            'user_id' => $user->id,
            'phone' => '081356598237',
            'gender' => 'pria',
            'dob' => '1997-10-15'
        ]);
        $arr = array("3.5", "4", "4.5", "5");
        \App\Models\Testimoni::create([
            'user_id' => $user->id,
            'deskripsi' => $faker->sentence,
            'bintang' => $arr[array_rand($arr)]
        ]);

        \App\Models\Alamat::create([
            'user_id' => $user->id,
            'kecamatan_id' => 5640,
            'nama' => 'Fiqy Ainuzzaqy',
            'telp' => '081356598237',
            'alamat' => 'Jl. Hikmat 50A Betro, Sedati, Sidoarjo',
            'lat' => '-7.3857584',
            'long' => '112.7574375',
            'kode_pos' => '61253',
            'isUtama' => true,
            'occupancy_id' => 8
        ]);
        \App\Models\Alamat::create([
            'user_id' => $user->id,
            'kecamatan_id' => 6833,
            'nama' => 'Laras Sulistyorini',
            'telp' => '082234389870',
            'alamat' => 'Desa Pakel, Tulungagung',
            'lat' => '-8.1501485',
            'long' => '111.7990778',
            'kode_pos' => '66273',
            'isUtama' => false,
            'occupancy_id' => 7
        ]);

        for ($i = 0; $i < 3; $i++) {
            $dataUser = \App\User::create([
                'name' => $faker->name,
                'username' => strtolower(str_replace(' ', '', $faker->name)),
                'email' => $faker->safeEmail,
                'password' => bcrypt('secret'),
                'status' => true,
            ]);
            \App\Models\Bio::create([
                'user_id' => $dataUser->id,
                'phone' => '+628123456789' . rand(0, 9),
                'gender' => rand(0, 1) ? 'pria' : 'warning',
                'dob' => $faker->date('Y-m-d')
            ]);

            $arr = array("3.5", "4", "4.5", "5");
            \App\Models\Testimoni::create([
                'user_id' => $dataUser->id,
                'deskripsi' => $faker->sentence,
                'bintang' => $arr[array_rand($arr)]
            ]);

            $kecamatan = \App\Models\Kecamatan::where('kota_id', 444)->inRandomOrder()->first();
            \App\Models\Alamat::create([
                'user_id' => $dataUser->id,
                'kecamatan_id' => $kecamatan->id,
                'nama' => $faker->name,
                'telp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'lat' => $faker->latitude,
                'long' => $faker->longitude,
                'kode_pos' => $kecamatan->getKota->kode_pos,
                'isUtama' => rand(0, 1) ? true : false,
                'occupancy_id' => rand(\App\Models\OccupancyType::min('id'), \App\Models\OccupancyType::max('id'))
            ]);
        }
    }
}
