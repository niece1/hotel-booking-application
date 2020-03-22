<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotelsplus\Interfaces\SiteRepositoryInterface;
use App\Hotelsplus\Gateways\SiteGateway;
use App\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class SiteController extends Controller
{
    public function __construct(SiteRepositoryInterface $siteRepository, SiteGateway $siteGateway)
    {
        $this->middleware('auth')->only(['makeReservation', 'addComment', 'like', 'unlike']);

        $this->siteRepository = $siteRepository;
        $this->siteGateway = $siteGateway;
    }

    public function index()
    {
        $objects = $this->siteRepository->getObjectsForMainPage();

        return view('site.index', ['objects' => $objects]);
    }

    public function article($id)
    {
        $article = $this->siteRepository->getArticle($id);
        return view('site.article', compact('article'));
    }

    public function object($id)
    {
        $object = $this->siteRepository->getObject($id);
        //	dd($object);

        return view('site.object', ['object' => $object]);
    }

    public function person($id)
    {
        $user = $this->siteRepository->getPerson($id);
        return view('site.person', ['user' => $user]);
    }

    public function room($id)
    {
        $room = $this->siteRepository->getRoom($id);
        return view('site.room', ['room' => $room]);
    }

    public function roomsearch(Request $request)
    {
        if ($city = $this->siteGateway->getSearchResults($request)) {
            // dd($city);
            return view('site.roomsearch', ['city' => $city]);
        } else {
            if (!$request->ajax()) //need for mobile app where no redirects exist
                return redirect('/')->with('norooms', __('No offers were found matching the criteria'));
        }
    }

    public function ajaxGetRoomReservations($id)
    {

        $reservations = $this->siteRepository->getReservationsByRoomId($id);

        return response()->json([
            'reservations' => $reservations
        ]);
    }

    public function searchCities(Request $request)
    {

        $results = $this->siteGateway->searchCities($request);

        return response()->json($results);
    }

    public function like($likeable_id, $type, Request $request)
    {
        $this->siteRepository->like($likeable_id, $type, $request);

        Cache::flush();

        return redirect()->back();
    }

    public function unlike($likeable_id, $type, Request $request)
    {
        $this->siteRepository->unlike($likeable_id, $type, $request);

        Cache::flush();

        return redirect()->back();
    }

    public function addComment($commentable_id, $type, Request $request)
    {
        $this->siteGateway->addComment($commentable_id, $type, $request);

        Cache::flush();

        return redirect()->back();
    }

    public function makeReservation($room_id, $city_id, Request $request)
    {
        $avaiable = $this->siteGateway->checkAvaiableReservations($room_id, $request);

        if (!$avaiable) {
            if (!$request->ajax()) {
                $request->session()->flash('reservationMsg', __('There are no vacancies'));
                return redirect()->route('room', ['id' => $room_id, '#reservation']);
            }

            return response()->json(['reservation' => false]);
        } else {
            $reservation = $this->siteGateway->makeReservation($room_id, $city_id, $request);

            event(new OrderPlacedEvent($reservation));

            if (!$request->ajax())
                return redirect()->route('adminHome');
            else
                return response()->json(['reservation' => $reservation]);
        }
    }
}
