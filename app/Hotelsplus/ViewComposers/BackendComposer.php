<?php

namespace App\Hotelsplus\ViewComposers; 

use Illuminate\View\View; 
use App\Notification; 
use Illuminate\Support\Facades\Auth; 


class BackendComposer
{


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('notifications', Notification::where('user_id', Auth::user()->id )->where('status',0)->get());
    }
}