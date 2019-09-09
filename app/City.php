<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function rooms()
    {
        return $this->hasManyThrough('App\Room', 'App\TouristObject','city_id','object_id');
    }
}
