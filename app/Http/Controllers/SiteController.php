<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotelsplus\Interfaces\SiteRepositoryInterface;

class SiteController extends Controller
{
	public function __construct(SiteRepositoryInterface $siteRepository)
    {
        $this->siteRepository = $siteRepository;
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
}
