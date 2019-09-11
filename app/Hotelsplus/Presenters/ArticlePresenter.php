<?php

namespace App\Hotelsplus\Presenters; 

trait ArticlePresenter {
    

    public function getLinkAttribute()
    {
        return route('article',['id'=>$this->id]);
    }
    
    public function getTypeAttribute()
    {
        return $this->title.' article';
    }
    
}