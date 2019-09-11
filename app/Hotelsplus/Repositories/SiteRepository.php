<?php

namespace App\Hotelsplus\Repositories; 

use App\TouristObject;
use App\City;
use App\Room;
use App\Reservation;
use App\Article;
use App\User;
use App\Comment;
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
       return  TouristObject::with(['city','shots', 'address','users.shots','rooms.shots','comments.user','articles.user','rooms.object.city'])->find($id); 
    }

    public function getSearchCities( string $term )
    {
        return  City::where('name', 'LIKE', $term . '%')->get();               
    }

    public function getSearchResults( string $city )
    {
       // return  City::where('name', $city)->get() ?? false;
       // rooms.object.photos  for json mobile
        return  City::with(['rooms.reservations','rooms.shots','rooms.object.shots'])->where('name',$city)->first() ?? false;  
    }

    public function getRoom($id)
    {
        // with() method - for mobile json
        return  Room::with(['object.address'])->find($id);
    } 
    

    public function getReservationsByRoomId( $room_id )
    {
        return  Reservation::where('room_id',$room_id)->get(); 
    }

    public function getArticle($id)
    {
        return  Article::with(['object.shots','comments'])->find($id);
    }

    public function getPerson($id)
    {
        return  User::with(['objects','larticles','comments.commentable'])->find($id);
    }

    public function like($likeable_id, $type, $request)
    {
        $likeable = $type::find($likeable_id);
      
        return $likeable->users()->attach($request->user()->id);
    }

    public function unlike($likeable_id, $type, $request)
    {
        $likeable = $type::find($likeable_id);
      
        return $likeable->users()->detach($request->user()->id);
    }

    public function addComment($commentable_id, $type, $request)
    {
        $commentable = $type::find($commentable_id);
        
        $comment = new Comment;
 
        $comment->content = $request->input('content');

        $comment->rating = $type == 'App\TouristObject' ? $request->input('rating') : 0;

        $comment->user_id = $request->user()->id;
        
        return $commentable->comments()->save($comment);
    }

    public function makeReservation($room_id, $city_id, $request)
    {
        return Reservation::create([
                'user_id'=>$request->user()->id,
                'city_id'=>$city_id,
                'room_id'=>$room_id,
                'status'=>0,
                'day_in'=>date('Y-m-d', strtotime($request->input('checkin'))),
                'day_out'=>date('Y-m-d', strtotime($request->input('checkout')))
            ]);
    }     
  
}