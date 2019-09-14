<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shot extends Model
{
    public function shotable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute($value)
    {
        return asset("storage/{$value}");
    }
    
    
    /* Lecture 40 */
    public function getStoragepathAttribute()
    {
        return $this->original['path'];
    }

    public static function imageRules($request,$type)
    {
        for ( $i = 0; $i <= count($request->file($type))-1 ; $i++ ) 
        {
            $rules["$type.$i"] = 'image|max:4000';
        }

        return $rules;
    }
}
