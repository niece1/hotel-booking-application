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

    public function article()
    {
        return view('site.article');
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
   
    public function room()
    {
        return view('site.room');
    }
 
    public function roomsearch()
    {
        return view('site.roomsearch');
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

    public function searchCities(Request $request)
    {

        $results = $this->siteGateway->searchCities($request);

        return response()->json($results);
    }

    
}
