<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';

    protected $guarded = ['id'];

    public function getVoucher()
    {
        return $this->hasMany(VouucherUser::class,'voucher_id');
    }
}
