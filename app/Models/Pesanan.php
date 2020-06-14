<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getKeranjang()
    {
        return $this->belongsTo(Keranjang::class,'keranjang_id');
    }
}
