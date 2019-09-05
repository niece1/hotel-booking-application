<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TouristObject extends Model
{
    protected $table = 'objects';

    public function city() 
    {
        return $this->belongsTo('App\City');
    }
    
    public function shots()
    {
        return $this->morphMany('App\Shot', 'shotable');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function users()
    {
        return $this->morphToMany('App\User', 'likeable');
    }
    
    public function address()
    {
        return $this->hasOne('App\Address','object_id'); //second argument isn't mandatory if model name and table name the same
    }
    
    public function rooms()
    {
        return $this->hasMany('App\Room','object_id');
    }
    
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
    
    public function articles()
    {
        return $this->hasMany('App\Article','object_id');
    }
}
