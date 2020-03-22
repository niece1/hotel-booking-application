<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Hotelsplus\Interfaces\BackendRepositoryInterface; 
use App\Hotelsplus\Gateways\BackendGateway; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ReservationConfirmedEvent;
use Illuminate\Support\Facades\Cache;

class BackendController extends Controller
{
    use \App\Hotelsplus\Traits\Ajax;

    public function __construct(BackendGateway $backendGateway, BackendRepositoryInterface $backendRepository)
    {
    	$this->middleware('CheckOwner')->only(['confirmReservation','saveRoom','saveObject','myObjects']); //names of methods

        $this->backendGateway = $backendGateway;
        $this->backendRepository = $backendRepository;
    }
       
    public function index(Request $request )
    {
        $objects = $this->backendGateway->getReservations($request); 
        return view('backend.index',['objects'=>$objects]);
    }
    
    public function cities()
    {
        return view('backend.cities');
    }
    
    public function myobjects(Request $request)
    {
        $objects = $this->backendRepository->getMyObjects($request); 
        //dd($objects); 

        return view('backend.myobjects',['objects'=>$objects]);
    }
    
    public function profile(Request $request)
    {
        if ($request->isMethod('post')) 
        {

            $user = $this->backendGateway->saveUser($request);
            
            if ($request->hasFile('userPicture'))
            {
                $path = $request->file('userPicture')->store('users', 'public'); 

                if (count($user->shots) != 0)
                {
                    $shot = $this->backendRepository->getShot($user->shots->first()->id);

                    Storage::disk('public')->delete($shot->storagepath);
                    $shot->path = $path;
                    
                    $this->backendRepository->updateUserShot($user,$shot);
                    
                } 
                else
                {
                    $this->backendRepository->createUserShot($user,$path);
                }
                
            }
             Cache::flush();

            return redirect()->back();
        }

        return view('backend.profile',['user'=>Auth::user()]);
    }
    
    public function saveobject($id = null, Request $request)
    {
        if($request->isMethod('post'))
        {
            if($id)
            $this->authorize('checkOwner', $this->backendRepository->getObject($id));

            $this->backendGateway->saveObject($id, $request);

            Cache::flush();

            if($id)
            return redirect()->back();
            else
            return redirect()->route('myObjects');

        }

        if($id)
        return view('backend.saveobject',['object'=>$this->backendRepository->getObject($id),'cities'=>$this->backendRepository->getCities()]);
        else
        return view('backend.saveobject',['cities'=>$this->backendRepository->getCities()]);
    }
    
   
    public function saveRoom($id = null, Request $request)
    {

        if($request->isMethod('post'))
        {
            if($id) // editing room
            $this->authorize('checkOwner', $this->backendRepository->getRoom($id));
            else // adding a new room
            $this->authorize('checkOwner', $this->backendRepository->getObject($request->input('object_id')));   

            $this->backendGateway->saveRoom($id, $request);

            Cache::flush();
            
            if($id)
            return redirect()->back();
            else
            return redirect()->route('myObjects');

        }

        if($id)
        return view('backend.saveroom',['room'=>$this->backendRepository->getRoom($id)]);
        else
        return view('backend.saveroom',['object_id'=>$request->input('object_id')]);
    }

    public function deleteRoom($id)
    {
        $room =  $this->backendRepository->getRoom($id); 
        
        $this->authorize('checkOwner', $room); 

        $this->backendRepository->deleteRoom($room); 

        Cache::flush();

        return redirect()->back();
    }

     public function confirmReservation($id)
    {
        $reservation = $this->backendRepository->getReservation($id); 

        $this->authorize('reservation', $reservation); 
        
        $this->backendRepository->confirmReservation($reservation); 
        
        $this->flashMsg ('success', __('Reservation has been confirmed'));  
        

        if (!\Request::ajax()) 
        return redirect()->back();
    }

    public function deleteReservation($id)
    {
        $reservation = $this->backendRepository->getReservation($id); 

        $this->authorize('reservation', $reservation); 

        $this->backendRepository->deleteReservation($reservation); 
        
        $this->flashMsg ('success', __('Reservation has been deleted'));

        event( new ReservationConfirmedEvent($reservation) );

        if (!\Request::ajax()) 
        return redirect()->back();
    }

    public function deleteShot($id)
    {

        $shot = $this->backendRepository->getShot($id); 
        
        $this->authorize('checkOwner', $shot);
        
        $path = $this->backendRepository->deleteShot($shot); 
        
        Storage::disk('public')->delete($path); 

        Cache::flush();

        return redirect()->back();
    }

    public function deleteArticle($id)
    {
        $article =  $this->backendRepository->getArticle($id); 
        
        $this->authorize('checkOwner', $article); 
        
        $this->backendRepository->deleteArticle($article);

        Cache::flush();

        return redirect()->back(); 
    }

    public function saveArticle($object_id = null, Request $request)
    {
        if(!$object_id) 
        {
           $this->flashMsg ('danger', __('First add an object')); 
           return redirect()->back();
        }

        $this->authorize('checkOwner', $this->backendRepository->getObject($object_id)); 

        $this->backendGateway->saveArticle($object_id,$request); 

        Cache::flush();

        return redirect()->back(); 
    }

    public function deleteObject($id)
    {
        $this->authorize('checkOwner', $this->backendRepository->getObject($id));
        
        $this->backendRepository->deleteObject($id);

        Cache::flush();
               
        return redirect()->back();
    
    }

    public function getNotifications()
    {
        return response()->json( $this->backendRepository->getNotifications() ); // mobile
    }

    public function setReadNotifications(Request $request)
    {
        return  $this->backendRepository->setReadNotifications($request); // mobile
    }
}