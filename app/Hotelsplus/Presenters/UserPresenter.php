<?php

namespace App\Hotelsplus\Presenters; 


trait UserPresenter {
      
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->surname;
    }
    
}