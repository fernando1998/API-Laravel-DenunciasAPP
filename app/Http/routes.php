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

// Api Controllers
Route::group(['prefix' => 'api/v1'], function(){
	//Api para login
    Route::post('login', 'Auth\ApiController@login');
     Route::post('register', 'Auth\ApiController@register');
	Route::resource('denuncias', 'DenunciasController');
	

});

