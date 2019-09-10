<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('site/index','SiteController@index')->name('home');
Route::get('/object/{id}','SiteController@object')->name('object');
Route::get('/adminHome','SiteController@adminHome')->name('adminHome');
//Route::post('/roomSearch','SiteController@roomsearch')->name('roomSearch');
Route::get(trans('routes.room').'/{id}','SiteController@room')->name('room'); 
Route::get(trans('routes.article').'/{id}','SiteController@article')->name('article'); 
Route::get(trans('routes.person'),'SiteController@person')->name('person');
Route::post(trans('routes.roomsearch'),'SiteController@roomsearch')->name('roomSearch');

Route::get('/searchCities', 'SiteController@searchCities');
Route::get('/ajaxGetRoomReservations/{id}', 'SiteController@ajaxGetRoomReservations');

Route::group(['prefix'=>'admin', 'middleware'=>'auth'],function(){  
    
  Route::get('/','BackendController@index')->name('adminHome');  
  Route::get(trans('routes.myobjects'),'BackendController@myobjects')->name('myObjects'); 
  Route::get(trans('routes.saveobject'),'BackendController@saveObject')->name('saveObject');  
  Route::get(trans('routes.profile'),'BackendController@profile')->name('profile');  
  Route::get(trans('routes.saveroom'),'BackendController@saveRoom')->name('saveRoom'); 
  Route::get('/cities','BackendController@cities')->name('cities.index');  
    
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
