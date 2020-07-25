<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';

    protected $guarded = ['id'];

    public function getProvinsi()
    {
        return $this->belongsTo(Provinsi::class,'provinsi_id');
    }

    public function getKecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kota_id');
    }
}
