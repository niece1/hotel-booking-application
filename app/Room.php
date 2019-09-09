<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function shots()
    {
        return $this->morphMany('App\Shot', 'shotable');
    }

    public function object()
    {
        return $this->belongsTo('App\TouristObject','object_id');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }
}
