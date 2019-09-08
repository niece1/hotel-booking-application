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
       // return TouristObject::find($id);
       // rooms.object.city   for json mobile because there is no lazy loading there
       return  TouristObject::with(['city','pshots', 'address','users.shots','rooms.shots','comments.user','articles.user','rooms.object.city'])->find($id); 
    }

    public function getSearchCities( string $term )
    {
        return  City::where('name', 'LIKE', $term . '%')->get();               
    }

    public function getSearchResults( string $city)
    {
        return  City::where('name', $city)->get() ?? false;  
    }  
  
}