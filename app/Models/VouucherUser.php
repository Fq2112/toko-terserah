<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VouucherUser extends Model
{
    protected $table = 'voucher_users';

    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getVoucher()
    {
        return $this->belongsTo(PromoCode::class,'voucher_id');
    }
}
