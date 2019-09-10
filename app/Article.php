<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->morphToMany('App\User', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function object()
    {
        return $this->belongsTo('App\TouristObject','object_id');
    }
}
