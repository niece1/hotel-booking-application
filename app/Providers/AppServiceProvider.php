<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Hotelsplus\Interfaces\SiteRepositoryInterface::class,function()
        {            
            return new \App\Hotelsplus\Repositories\SiteRepository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('site.*', function ($view) {
            $view->with('placeholder', asset('images/placeholder.png')); 
        });
    }
}
