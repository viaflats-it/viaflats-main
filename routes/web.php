<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/* ----------------------
                            For everyone
                                        ---------------------- */
Route::get('index', 'PageController@index');



/* ----------------------
                        Not connected :
                                        ---------------------- */
Route::group(['middleware' => 'guest'], function() {
    Route::post('login', 'LoginController@signIn');
    Route::post('signup', 'LoginController@signUp');
});


/* ----------------------
                      connected as a Tenant :
                                        ---------------------- */
Route::group(['middleware' => 'auth'], function() {
    Route::get('logout', 'LoginController@logOut');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('logoutfb', 'LoginController@logOutFb');
Route::get('fbsignup', 'LoginController@signUpFacebook');
Route::get('logingoogle', 'LoginController@signUpGoogle');
Route::get('logoutgoogle', 'LoginController@logOutGoogle');



/* ----------------------
                         connected as a Landlord :
                                        ---------------------- */
Route::group(['middleware' => 'landlord'], function() {
    Route::get('landlord', 'Pagecontroller@landlord');
});


/* ----------------------
                      connected as an Admin :
                                        ---------------------- */

Route::group(['middleware' => 'admin'], function() {

});
