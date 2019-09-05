<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function shots()
    {
        return $this->morphMany('App\Shot', 'shotable');
    }
}
