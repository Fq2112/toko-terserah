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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getKecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function getOccupancy()
    {
        return $this->belongsTo(OccupancyType::class, 'occupancy_id');
    }
}
