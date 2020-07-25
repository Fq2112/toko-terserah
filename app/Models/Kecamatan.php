<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $guarded = ['id'];

    public function getKota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function getAlamat()
    {
        return $this->hasMany(Alamat::class, 'kecamatan_id');
    }
}
