<?php

namespace App\Hotelsplus\Repositories; 

use App\TouristObject;
use App\Hotelsplus\Interfaces\SiteRepositoryInterface;

class SiteRepository implements SiteRepositoryInterface
 {
    public function getObjectsForMainPage()
    {
      //  return TouristObject::all(); //lazyloading
        return TouristObject::with(['city','shots'])->ordered()->paginate(8); //eagerloading
    }

    public function getObject($id)
    {
        return TouristObject::find($id); 
    } 
  
}