<?php

namespace App\Hotelsplus\Interfaces; 


interface SiteRepositoryInterface 
{
 
    public function getObjectsForMainPage();

    public function getObject($id);
  
}