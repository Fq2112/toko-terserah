<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
