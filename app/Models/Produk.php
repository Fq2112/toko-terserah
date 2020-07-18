<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $guarded = ['id'];

    public function getSubkategori()
    {
        return $this->belongsTo(SubKategori::class, 'sub_kategori_id');
    }

    public function getKeranjang()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }

    public function getUlasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id');
    }

    public static function getMurah()
    {
        return Produk::orderBy('harga')->first()->harga;
    }

    public static function getMahal()
    {
        return Produk::orderByDesc('harga')->first()->harga;
    }
}
