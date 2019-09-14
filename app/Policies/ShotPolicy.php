<?php

namespace App\Policies;

use App\{User,Shot};
use Illuminate\Auth\Access\HandlesAuthorization;

class ShotPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function checkOwner(User $user, Shot $shot)
    {
        if($shot->shotable_type == 'App\User')
        return $user->id === $shot->shotable_id;    
        elseif($shot->shotable_type == 'App\TouristObject')
        return $user->id === $shot->shotable->user_id;   
        elseif($shot->shotable_type == 'App\Room')
        return $user->id === $shot->shotable->object->user_id;   
         
    }
}
