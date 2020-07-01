<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    protected $guarded = ['id'];

    public function getKota()
    {
        return $this->hasMany(Kota::class,'provinsi_id');
    }
}
