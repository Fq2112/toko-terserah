<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    protected $table = 'produk';

    protected $guarded = ['id'];

    protected $casts = ['galeri' => 'array'];

    public function getSubkategori()
    {
        return $this->belongsTo(SubKategori::class, 'sub_kategori_id');
    }

    public function getWishlist()
    {
        return $this->hasMany(Favorit::class, 'produk_id');
    }

    public function getKeranjang()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }

    public function getUlasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id');
    }

    public function getQnA()
    {
        return $this->hasMany(QnA::class, 'produk_id');
    }

    public static function getMurah()
    {
        $data = Produk::orderBy(DB::raw("IF(is_diskon=0, harga, harga_diskon)"))->first();
        return !is_null($data) ? $data->harga : 0;
    }

    public static function getMahal()
    {
        $data = Produk::orderByDesc(DB::raw("IF(is_diskon=0, harga, harga_diskon)"))->first();
        return !is_null($data) ? $data->harga : 0;
    }
}
