<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotelsplus\Interfaces\SiteRepositoryInterface;
use App\Hotelsplus\Gateways\SiteGateway;

class SiteController extends Controller
{
	public function __construct(SiteRepositoryInterface $siteRepository, SiteGateway $siteGateway)
    {
        $this->siteRepository = $siteRepository;
        $this->siteGateway = $siteGateway;
    }
    
    public function index()
    {
    	$objects = $this->siteRepository->getObjectsForMainPage();

        return view('site.index',['objects'=>$objects]);
    }

    public function article($id)
    {
    	$article = $this->siteRepository->getArticle($id);
        return view('site.article',compact('article'));
    }
   
    public function object($id)
    {
    	$object = $this->siteRepository->getObject($id);
    //	dd($object);

        return view('site.object', ['object'=>$object]);
    }
  
    public function person()
    {
        return view('site.person');
    }
   
    public function room($id)
    {
        $room = $this->siteRepository->getRoom($id); 
        return view('site.room',['room'=>$room]);
    }

    public function roomsearch(Request $request )
    {
        if($city = $this->siteGateway->getSearchResults($request))
        {
            dd($city);
            return view('site.roomsearch',['city'=>$city]);
        }
        else 
        {
            if (!$request->ajax())
            return redirect('/')->with('norooms', __('No offers were found matching the criteria'));
        }
        
    }

    public function ajaxGetRoomReservations($id)
    {
        
        $reservations = $this->siteRepository->getReservationsByRoomId($id);
        
        return response()->json([
            'reservations'=>$reservations
        ]);
    }

    public function searchCities(Request $request)
    {

        $results = $this->siteGateway->searchCities($request);

        return response()->json($results);
    }

    
}
