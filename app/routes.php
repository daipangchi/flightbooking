<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('id', '[0-9]+');

// Service
Route::get('/Service/GetAirportByPrefix',								['as' => 'service.airport.getByPrefix',     'uses' => 'ServiceController@getAirportByPrefix']);
Route::match(['get', 'post'], '/Service/GetSearchResult',				['as' => 'service.airport.getResult',       'uses' => 'ServiceController@getResult']);
Route::match(['get', 'post'], '/Service/GetSearchResultWithFilter',     ['as' => 'service.airport.getResultWithFilter',       'uses' => 'ServiceController@getResultWithFilter']);

// Newsletter
Route::post('nyhetsbrev', 'NewsletterController@add_subscriber');

// Home
Route::get('/',                 ['as' => 'home.index',      'uses' => 'FlightController@index']);

// Pages
Route::get('/flygradsla/',       ['as' => 'page.flygradsla',    'uses' => 'PageController@flygradsla']);
Route::get('/gravid/',           ['as' => 'page.gravid',        'uses' => 'PageController@gravid']);
Route::get('/omoss/',            ['as' => 'page.omoss',         'uses' => 'PageController@omoss']);
Route::get('/hittades-inte/',    ['as' => 'page.404',           'uses' => 'PageController@notFound']);
Route::get('/destinationer/',    ['as' => 'page.destinationer', 'uses' => 'PageController@destinationer']);

// Flight
Route::get('/flights',          ['as' => 'flight.index',    'uses' => 'FlightController@index']);
Route::get('/flights/search',   ['as' => 'flight.search',   'uses' => 'FlightController@search']);
Route::get('/flights/GetAirportByPrefix',           ['as' => 'flight.airports',             'uses' => 'FlightController@getAirportByPrefix']);
Route::post('/flights/GetTripSearch',               ['as' => 'flight.trip.search',          'uses' => 'FlightController@getTripSearch']);
Route::post('/flights/GetTripSearchWithFilter',     ['as' => 'flight.trip.search.filter',   'uses' => 'FlightController@getTripSearchWithFilter']);

// Destination Pages
//Route::post('temp/save', 'PageController@saveCity');
Route::get('{slug}/', 'PageController@city');