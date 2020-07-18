<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $guarded = ['id'];

    protected $casts = ['keranjang_ids' => 'array'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPengiriman()
    {
        return $this->belongsTo(Alamat::class, 'pengiriman_id');
    }

    public function getPenagihan()
    {
        return $this->belongsTo(Alamat::class, 'penagihan_id');
    }
}
