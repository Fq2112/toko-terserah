<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $guarded = ['id'];

    public function getSubkategori()
    {
        return $this->belongsTo(SubKategori::class,'sub_kategori_id');
    }

    public function getKerajang()
    {
        return $this->hasMany(Keranjang::class,'produk_id');
    }
}
