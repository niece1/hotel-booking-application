<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (App::environment('local'))
        {
            
            $this->app->bind(\App\Hotelsplus\Interfaces\SiteRepositoryInterface::class,function()
            {            
                return new \App\Hotelsplus\Repositories\SiteRepository;
            });
  
        }
        else
        {
            
            $this->app->bind(\App\Hotelsplus\Interfaces\SiteRepositoryInterface::class,function()
            {            
                return new \App\Hotelsplus\Repositories\CachedSiteRepository;
            });  

        }

        $this->app->bind(\App\Hotelsplus\Interfaces\BackendRepositoryInterface::class,function()
        {            
            return new \App\Hotelsplus\Repositories\BackendRepository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('backend.*', '\App\Hotelsplus\ViewComposers\BackendComposer');

        View::composer('site.*', function ($view) {
            $view->with('placeholder', asset('images/placeholder.png')); 
        });

        if (App::environment('local'))
        {
            
           View::composer('*', function ($view) {
            $view->with('novalidate', 'novalidate');
            });
  
        }
        else
        {
            View::composer('*', function ($view) {
            $view->with('novalidate', null);
            });
        }
    }
}
