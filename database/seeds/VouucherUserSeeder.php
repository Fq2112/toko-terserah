<?php

use Illuminate\Database\Seeder;

class VouucherUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\User::all() as $user){
            foreach (\App\Models\PromoCode::all() as $item){
                \App\Models\VouucherUser::query()->create([
                    'user_id' => $user->id,
                    'voucher_id' => $item->id,
                ]);
            }
        }
    }
}
