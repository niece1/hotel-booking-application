<?php

namespace App\Hotelsplus\Repositories; 

use App\Hotelsplus\Interfaces\BackendRepositoryInterface; 
use App\TouristObject;
use App\Reservation;
use App\City;
use App\User;
use App\Shot;
use App\Address;
use App\Article;
use App\Room;

class BackendRepository implements BackendRepositoryInterface  
{   
   public function getOwnerReservations($request)
    {
        return TouristObject::with([

                  'rooms' => function($q) {
                        $q->has('reservations'); // works like where clause for Room
                    }, // give me rooms only with reservations, if it wasn't there would be rooms without reservations

                    'rooms.reservations.user'

                  ])
                    ->has('rooms.reservations') // ensures that it gives me only those objects that have at least one reservation, has() here works like where clause for Object
                    ->where('user_id', $request->user()->id)
                    ->get();
    }

    public function getTouristReservations($request)
    {

       return TouristObject::with([

                    'rooms.reservations' => function($q) use($request) { // filters reserervations of other users

                            $q->where('user_id',$request->user()->id);

                    },

                    'rooms'=>function($q) use($request){
                        $q->whereHas('reservations',function($query) use($request){
                            $query->where('user_id',$request->user()->id);
                        });
                    },
                    
                    'rooms.reservations.user'

                  ])

                    ->whereHas('rooms.reservations',function($q) use($request){  // acts like has() with additional conditions

                        $q->where('user_id',$request->user()->id);

                    })
                    ->get();
    }

    public function getReservationData($request)
    {
        return  Reservation::with('user', 'room')
                ->where('room_id', $request->input('room_id'))
                ->where('day_in', '<=', date('Y-m-d', strtotime($request->input('date'))))
                ->where('day_out', '>=', date('Y-m-d', strtotime($request->input('date'))))
                ->first();
    }

    public function getReservation($id)
    {
        return Reservation::find($id);
    }
       
   
    public function deleteReservation(Reservation $reservation)
    {
        return $reservation->delete();
    }
        
    
    public function confirmReservation(Reservation $reservation)
    {
        return $reservation->update(['status' => true]);
    }

    public function getCities()
    {
        return City::orderBy('name','asc')->get();
    }
    
    
    /* Lecture 37 */
    public function getCity($id)
    {
        return City::find($id);
    }
    
    
    /* Lecture 37 */
    public function createCity($request)
    {
        return City::create([
            'name' => $request->input('name')
        ]);
    }
    
    
    /* Lecture 37 */
    public function updateCity($request, $id)
    {
        return City::where('id',$id)->update([
            'name' => $request->input('name')
        ]);
    }
    
    
    /* Lecture 37 */
    public function deleteCity($id)
    {
        return City::where('id',$id)->delete();
    }

    public function saveUser($request)
    {
        $user = User::find($request->user()->id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->save();

        return $user;
    }

    public function getShot($id)
    {
        return Shot::find($id);
    }
    
    
    /* Lecture 40 */
    public function updateUserShot(User $user,Shot $shot)
    {
        return $user->shots()->save($shot);
    }
    
    /* Lecture 40 */
    public function createUserShot($user,$path)
    {
        $shot = new Shot;
        $shot->path = $path;
        $user->shots()->save($shot);
    }
    
    /* Lecture 40 */
    public function deleteShot(Shot $shot)
    {
        $path = $shot->storagepath;
        $shot->delete();
        return $path;
    }

    public function getObject($id)
    {
        return TouristObject::find($id);
    }
    
    
    /* Lecture 42 */
    public function updateObjectWithAddress($id, $request)
    {

        Address::where('object_id',$id)->update([
            'street'=>$request->input('street'),
            'number'=>$request->input('number'),
            ]);

        $object = TouristObject::find($id);


        $object->name = $request->input('name');
        $object->city_id = $request->input('city');
        $object->description = $request->input('description');

        $object->save();

        return $object;

    }
    
    
    /* Lecture 42 */
    public function createNewObjectWithAddress($request)
    {
        $object = new TouristObject;
        $object->user_id = $request->user()->id;

        $object->name = $request->input('name');
        $object->city_id = $request->input('city');
        $object->description = $request->input('description');

        $object->save();


        $address = new Address;
        $address->street = $request->input('street');
        $address->number = $request->input('number');
        $address->object_id = $object->id;
        $address->save();
        $object->address()->save($address);

        return $object;
    }

    public function saveObjectShots(TouristObject $object, string $path)
    {

        $shot = new Shot;
        $shot->path = $path;
        return $object->shots()->save($shot);

    } 

    public function saveArticle($object_id,$request)
    {
            return Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
            'object_id' =>$object_id,
          //  'created_at' => new \DateTime(),
        ]);
    }
    
    /* Lecture 45 */
    public function getArticle($id)
    {
        return Article::find($id);
    }
    
    
    /* Lecture 45 */
    public function deleteArticle(Article $article)
    {
        return  $article->delete();
    }

    public function getMyObjects($request)
    {
        return TouristObject::where('user_id',$request->user()->id)->get();
    }
    
    
    /* Lecture 46 */
    public function deleteObject($id)
    {
        return TouristObject::where('id',$id)->delete();
    }

    public function getRoom($id)
    {
        return Room::find($id);
    }

    public function updateRoom($id,$request)
    {
        $room = Room::find($id);
        $room->room_number = $request->input('room_number');
        $room->room_size = $request->input('room_size');
        $room->price = $request->input('price');
        $room->description = $request->input('description');

        $room->save();

        return $room;
    }
    
    
    /* Lecture 48 */
    public function createNewRoom($request)
    {
        $room = new Room;
        $object = TouristObject::find( $request->input('object_id') );
        $room->object_id = $request->input('object_id') ;

        $room->room_number = $request->input('room_number');
        $room->room_size = $request->input('room_size');
        $room->price = $request->input('price');
        $room->description = $request->input('description');

        $room->save();

        $object->rooms()->save($room);

        return $room;
    }
    
    
    /* Lecture 48 */
    public function saveRoomShots(Room $room, string $path)
    {
        $shot = new Shot;
        $shot->path = $path;
        return $room->shots()->save($shot); 
    }
    
    
    /* Lecture 48 */
    public function deleteRoom(Room $room)
    {
        return $room->delete();
    }
  
}