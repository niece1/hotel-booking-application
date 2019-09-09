<?php

namespace App\Hotelsplus\Gateways;

use App\Hotelsplus\Interfaces\SiteRepositoryInterface; 


class SiteGateway { 
    
 
    public function __construct(SiteRepositoryInterface $siteRepository ) 
    {
        $this->siteRepository = $siteRepository;
    }
   
    public function searchCities($request)
    {
        $term = $request->input('term');

        $results = array();

        $queries = $this->siteRepository->getSearchCities($term);

        foreach ($queries as $query)
        {
            $results[] = ['id' => $query->id, 'value' => $query->name];
        }

        return $results;
    }

    public function getSearchResults($request)
    {

        if( $request->input('city') != null)
        {
            $dayin = date('Y-m-d', strtotime($request->input('check_in'))); 
            $dayout = date('Y-m-d', strtotime($request->input('check_out')));

            $result = $this->siteRepository->getSearchResults($request->input('city'));

            if($result)
            {

                foreach ($result->rooms as $k=>$room)
                {
                   if( (int) $request->input('room_size') > 0 )
                   {
                        if($room->room_size != $request->input('room_size'))
                        {
                            $result->rooms->forget($k);
                        }
                   }

                    foreach($room->reservations as $reservation)
                    {

                        if( $dayin >= $reservation->day_in
                            &&  $dayin <= $reservation->day_out
                        )
                        {
                            $result->rooms->forget($k);
                        }
                        elseif( $dayout >= $reservation->day_in
                            &&  $dayout <= $reservation->day_out
                        )
                        {
                            $result->rooms->forget($k);
                        }
                        elseif( $dayin <= $reservation->day_in
                            &&  $dayout >= $reservation->day_out
                        )
                        {
                            $result->rooms->forget($k);
                        }

                    }

                }

                if(count($result->rooms)> 0)
                return $result;  // filtered result
                else return false;

            }

        }
        
        return false;

    } 

}