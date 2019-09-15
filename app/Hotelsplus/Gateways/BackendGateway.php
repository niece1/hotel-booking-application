<?php

namespace App\Hotelsplus\Gateways; 

use App\Hotelsplus\Interfaces\BackendRepositoryInterface; 


class BackendGateway
 { 
    
    use \Illuminate\Foundation\Validation\ValidatesRequests;
    public function __construct(BackendRepositoryInterface $backendRepository ) 
    {
        $this->backendRepository = $backendRepository;
    }
    
    
    
    public function getReservations($request)
    {
        if ($request->user()->hasRole(['owner','admin']))
        {

            $objects = $this->backendRepository->getOwnerReservations($request);

        }
        else
        {
            
            $objects = $this->backendRepository->getTouristReservations($request);
        }
        
        return $objects;
    }

    public function createCity($request)
    {
        $this->validate($request,[
        'name'=>"required|string",
        ]);
        
        $this->backendRepository->createCity($request);
    }
    
    
    /* Lecture 37 */
    public function updateCity($request, $id)
    {
        $this->validate($request,[
        'name'=>"required|string",
        ]);
        
        $this->backendRepository->updateCity($request, $id);
    }

    public function saveUser($request)
    {
        $this->validate($request,[
        'name'=>"required|string",
        'surname'=>"required|string",
        'email'=>"required|email",
        ]);
        
        if ($request->hasFile('userPicture'))
        {
            $this->validate($request,[
            'userPicture'=>"image|max:100",

            ]);
        }
        
        return $this->backendRepository->saveUser($request);
    }

    public function saveObject($id, $request)
    {

        $this->validate($request,[
            'city'=>"required|string",
            'name'=>"required|string",
            'street'=>"required|string",
            'number'=>"required|integer",
            'description'=>"required|string|min:100",
        ]);
        
        
        if($id)
        {
            $object = $this->backendRepository->updateObjectWithAddress($id, $request);
        }
        else
        {
            $object = $this->backendRepository->createNewObjectWithAddress($request);
        }


        if ($request->hasFile('objectPictures'))
        {
            $this->validate($request, \App\Shot::imageRules($request,'objectPictures'));
            foreach($request->file('objectPictures') as $picture)
            {
                $path = $picture->store('objects', 'public');

                $this->backendRepository->saveObjectShots($object, $path);
            }

        }
                
        return $object;               
    }

    public function saveArticle($object_id,$request)
    {
        $this->validate($request,[
            'content'=>"required|min:10",
            'title'=>"required|min:3",
        ]);

        return $this->backendRepository->saveArticle($object_id,$request);

    }

     public function saveRoom($id, $request)
    {
    
        $this->validate($request,[
        'room_number'=>"required|integer",
        'room_size'=>"required|integer",
        'price'=>"required|integer",
        'description'=>"required|string|min:100",
        ]);

        if($id)
        {
            $room = $this->backendRepository->updateRoom($id,$request); /* Lecture 48 */

        }
        else
        {
            $room = $this->backendRepository->createNewRoom($request); /* Lecture 48 */
        }


        if ($request->hasFile('roomPictures'))
        {
            $this->validate($request, \App\Shot::imageRules($request,'roomPictures'));

            foreach($request->file('roomPictures') as $picture)
            {
                $path = $picture->store('rooms', 'public');

                $this->backendRepository->saveRoomPhotos($room, $path); /* Lecture 48 */
            }

        }

            return $room; /* Lecture 48 */
            
    }

    public function checkNotificationsStatus($request)
    {
        
        set_time_limit(0);

        $memcache = new \Memcached();

        $memcache->addServer('localhost', 11211) or die("Could not connect");

        $currentmodif = (int) $memcache->get('userid_' . $request->user()->id . '_notification_timestamp');

        $lastmodif = $request->input('timestamp') ?? 0;

        $start = microtime(true);

        $response = array();


        while ($currentmodif <= $lastmodif)
        {

            if ( (microtime(true) - $start) > 10)
            {
                return json_encode($response);
            }


            sleep(0.1);
            $currentmodif = (int) $memcache->get('userid_' . $request->user()->id . '_notification_timestamp');
        }
        
        
        return $currentmodif;
    }

}