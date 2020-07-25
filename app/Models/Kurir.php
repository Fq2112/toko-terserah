<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';

    protected $guarded = ['id'];

    public function getPesanan()
    {
        return $this->hasMany(Pesanan::class, 'kurir_id');
    }
}
