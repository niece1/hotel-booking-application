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

            $result = $this->siteRepository->getSearchResults($request->input('city'));

            if($result)
            {

                // to do: filter results based on check in and check out etc.

                $request->flash(); // inputs for session for one request

                return $result; // filtered result

            }

        }
        
        return false;

    } 

}