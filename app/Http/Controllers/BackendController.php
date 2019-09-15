<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Hotelsplus\Interfaces\BackendRepositoryInterface; 
use App\Hotelsplus\Gateways\BackendGateway; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BackendController extends Controller
{
    use \App\Hotelsplus\Traits\Ajax;

    public function __construct(BackendGateway $backendGateway, BackendRepositoryInterface $backendRepository)
    {
    	$this->middleware('CheckOwner')->only(['confirmReservation','saveRoom','saveObject','myObjects']); //names of methods

        $this->backendGateway = $backendGateway;
        $this->backendRepository = $backendRepository;
    }
    
    
    /* Lecture 6 */
    public function index(Request $request )
    {
        $objects = $this->backendGateway->getReservations($request); 
        return view('backend.index',['objects'=>$objects]);
    }
    
    /* Lecture 6 */
    public function cities()
    {
        return view('backend.cities');
    }
    
    public function myobjects(Request $request /* Lecture 46 */)
    {
        $objects = $this->backendRepository->getMyObjects($request); /* Lecture 46 */
        //dd($objects); /* Lecture 46 */

        return view('backend.myobjects',['objects'=>$objects]/* Lecture 46 */);
    }
    
    /* Lecture 6 */
    public function profile(Request $request /* Lecture 39 */)
    {
        /* Lecture 39 */
        if ($request->isMethod('post')) 
        {

            $user = $this->backendGateway->saveUser($request);
            
            if ($request->hasFile('userPicture'))
            {
                $path = $request->file('userPicture')->store('users', 'public'); /* Lecture 40 */

                /* Lecture 40 */
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


            return redirect()->back();
        }

        return view('backend.profile',['user'=>Auth::user()]/* Lecture 39 */);
    }
    
    public function saveobject($id = null, Request $request /* Lecture 41 two args */)
    {
        /* Lecture 41 */
        if($request->isMethod('post'))
        {
            if($id)
            $this->authorize('checkOwner', $this->backendRepository->getObject($id));

            $this->backendGateway->saveObject($id, $request);

            if($id)
            return redirect()->back();
            else
            return redirect()->route('myObjects');

        }


        /* Lecture 41 */
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
        $room =  $this->backendRepository->getRoom($id); /* Lecture 48 */
        
        $this->authorize('checkOwner', $room); /* Lecture 48 */

        $this->backendRepository->deleteRoom($room); /* Lecture 48 */

        return redirect()->back(); /* Lecture 48 */
    }

     public function confirmReservation($id)
    {
        $reservation = $this->backendRepository->getReservation($id); /* Lecture 35 */

        $this->authorize('reservation', $reservation); /* Lecture 35 */
        
        $this->backendRepository->confirmReservation($reservation); /* Lecture 35 */
        
        $this->flashMsg ('success', __('Reservation has been confirmed'));  /* Lecture 35 */
        

        if (!\Request::ajax()) /* Lecture 35 */
        return redirect()->back();
    }

    
    /* Lecture 33 */
    public function deleteReservation($id)
    {
        $reservation = $this->backendRepository->getReservation($id); /* Lecture 35 */

        $this->authorize('reservation', $reservation); /* Lecture 35 */

        $this->backendRepository->deleteReservation($reservation); /* Lecture 35 */
        
        $this->flashMsg ('success', __('Reservation has been deleted'));

        event( new ReservationConfirmedEvent($reservation) );

        if (!\Request::ajax()) /* Lecture 35 */
        return redirect()->back();
    }

    public function deleteShot($id)
    {

        $shot = $this->backendRepository->getShot($id); /* Lecture 40 */
        
        $this->authorize('checkOwner', $shot);
        
        $path = $this->backendRepository->deleteShot($shot); /* Lecture 40 */
        
        Storage::disk('public')->delete($path); /* Lecture 40 */

        return redirect()->back();
    }

    public function deleteArticle($id)
    {
        $article =  $this->backendRepository->getArticle($id); /* Lecture 45 */
        
        $this->authorize('checkOwner', $article); /* Lecture 45 */
        
        $this->backendRepository->deleteArticle($article); /* Lecture 45 */

        return redirect()->back(); /* Lecture 45 */ 
    }
    
    
    /* Lecture 44 */
    public function saveArticle($object_id = null, Request $request /* Lecture 45 */)
    {
        /* Lecture 45 */
        if(!$object_id) 
        {
           $this->flashMsg ('danger', __('First add an object')); 
           return redirect()->back();
        }

        $this->authorize('checkOwner', $this->backendRepository->getObject($object_id)); /* Lecture 45 */

        $this->backendGateway->saveArticle($object_id,$request); /* Lecture 45 */

        return redirect()->back(); /* Lecture 45 */
    }

    public function deleteObject($id)
    {
        $this->authorize('checkOwner', $this->backendRepository->getObject($id));
        
        $this->backendRepository->deleteObject($id);
               
        return redirect()->back();
    
    }

    public function getNotifications()
    {
        return response()->json( $this->backendRepository->getNotifications() ); // for mobile
    }
    
    
    /* Lecture 53 */
    public function setReadNotifications(Request $request)
    {
        return  $this->backendRepository->setReadNotifications($request); // for mobile
    }
}