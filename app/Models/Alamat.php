<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
   protected $table = 'alamat';

   protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getKota()
    {
        return $this->hasOne(Kota::class,'kota_id');
    }
}
