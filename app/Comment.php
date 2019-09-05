<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Hotelsplus\Presenters\CommentPresenter; 

    
    public function commentable()
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
