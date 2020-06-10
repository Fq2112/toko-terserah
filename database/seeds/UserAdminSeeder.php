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

        $user = \App\User::create([
            'name' => 'Fiqy Ainuzzaqy',
            'username' => 'jQuinn',
            'email' => 'fiqy_a@icloud.com',
            'password' => bcrypt('secret'),
            'status' => true,
        ]);

        \App\Models\Bio::create(['user_id' => $user->id]);

        for ($i = 0; $i < 3; $i++) {
            $dataUser = \App\User::create([
                'name' => $faker->name,
                'username' => $faker->name,
                'email' => $faker->safeEmail,
                'password' => bcrypt('secret'),
                'status' => true,
            ]);
            \App\Models\Bio::create(['user_id' => $dataUser->id]);
        }
    }
}
