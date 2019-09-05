<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shot extends Model
{
    public function shotable()
    {
        return $this->morphTo();
    }
}
