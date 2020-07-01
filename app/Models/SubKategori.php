<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table = 'sub_kategori';

    protected $guarded = ['id'];


    public function getKategori()
    {
        return $this->belongsTo(Kategori::class,'kategori_id');
    }

    public function getProduk()
    {
        return $this->hasMany(Produk::class,'sub_kategori_id');
    }
}
