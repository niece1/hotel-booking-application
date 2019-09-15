<?php

namespace App\Hotelsplus\ViewComposers; /* Lecture 49 */

use Illuminate\View\View; /* Lecture 49 */
use App\Notification; /* Lecture 49 */
use Illuminate\Support\Facades\Auth; /* Lecture 49 */


 /* Lecture 49 */
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