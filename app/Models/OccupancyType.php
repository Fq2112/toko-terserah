<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OccupancyType extends Model
{
    protected $table = 'occupancy_types';

    protected $guarded = ['id'];

    public function getAlamat()
    {
        return $this->hasMany(Alamat::class, 'occupancy_id');
    }
}
