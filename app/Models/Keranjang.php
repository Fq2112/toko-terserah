<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getProduk()
    {
        return $this->belongsTo(Produk::class,'produk_id');
    }

    public function getPesanan()
    {
        return $this->hasOne(Pesanan::class,'keranjang_id');
    }
}
