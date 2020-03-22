<?php

namespace App\Hotelsplus\Repositories; 

use App\Hotelsplus\Interfaces\SiteRepositoryInterface;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Redis;


/* Lecture 55 */
class CachedSiteRepository extends SiteRepository implements SiteRepositoryInterface {
    
    
    public function getObjectsForMainPage()
    {
        
        return Cache::remember('getObjectsForMainPage'. \Request::input('page'), 1140, function() {
            
            return parent::getObjectsForMainPage();
            
        });

    }   


    public function getObject($id)
    {
        return Cache::remember('getObject'.$id, 1140, function() use($id) {
            
            return parent::getObject($id);
            
        });

    }    



    public function getSearchCities( string $term)
    {
        return Cache::remember('getSearchCities'.$term, 1140, function() use($term) {
            
            return parent::getSearchCities($term);
            
        });
           
    } 
    
    
    
    public function getSearchResults( string $city)
    {
        return Cache::remember('getSearchResults'.$city, 1140, function() use($city) {
            
            return parent::getSearchResults($city);
            
        });

    }  

    
    public function getRoom($id)
    {
        return Cache::remember('getRoom'.$id, 1140, function() use($id) {
            
            return parent::getRoom($id);
            
        });

    } 
    
    
    public function getReservationsByRoomId( $room_id )
    {
        return parent::getReservationsByRoomId( $room_id );
    }  

    
    public function getArticle($id)
    {
        return Cache::remember('getArticle'.$id, 1140, function() use($id) {
            
            return parent::getArticle($id);
            
        });

    }    
    

    public function getPerson($id)
    {
        return Cache::remember('getPerson'.$id, 1140, function() use($id) {
            
            return parent::getPerson($id);
            
        });
    }    

 
    public function like($likeable_id, $type, $request)
    {
        return parent::like($likeable_id, $type, $request);
    }
    
    
    public function unlike($likeable_id, $type, $request)
    {
        return parent::unlike($likeable_id, $type, $request);
    }



    public function makeReservation($room_id, $city_id, $request)
    {
        return parent::makeReservation($room_id, $city_id, $request);
    }
    
    
    public function addComment($commentable_id, $type, $request)
    {
        return parent::addComment($commentable_id, $type, $request);
    }
    
    

}