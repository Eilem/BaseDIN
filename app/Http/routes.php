<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


//página de erro
Route::get('/404', [ 'as' => '404', 'uses' => 'ErrorController@index' ]);

//sitemap
Route::get('/sitemap.xml', [ 'as' => 'sitemap.index', 'uses' => 'SitemapController@index' ]);


/**
 * Home 
 */
Route::get('/', [ 'as' => 'home.index', 'uses' => 'HomeController@index' ]);


/**
 * Cache
 */
 Route::group( ['prefix' => 'cache'], function(){
     
    Route::get('/clear/all', [ 'as' => 'cache.clear.all', 'uses' => 'CacheController@clearAll' ] );

 });