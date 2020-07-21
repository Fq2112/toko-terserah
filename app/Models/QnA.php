<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class QnA extends Model
{
    protected $table = 'QnA';

    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getProduk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
