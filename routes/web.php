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


/* ----------------------
                         connected as a Landlord :
                                        ---------------------- */
Route::group(['middleware' => 'landlord'], function() {
    Route::get('landlord', 'LandlordController@showProfile');

    Route::get('profile', 'LandlordController@showProfile');
    Route::post('profile', 'LandlordController@updateProfile');

    Route::post('landlord_picture', 'LandlordController@updatePicture');
    Route::post('updatePassword', 'LandlordController@updatePassword');
    Route::post('updateInformation', 'LandlordController@updateInformation');

    Route::get('add_property', 'LandlordController@showAddProperty');
    Route::get('my_properties', 'LandlordController@showProperties');
    Route::get('my_booking', 'LandlordController@showBooking');
    Route::get('update_availabilities', 'LandlordController@showUpdateAvailabilities');
    Route::get('invoices', 'LandlordController@showInvoices');
    Route::get('messages', 'LandlordController@showMessages');


});


/* ----------------------
                      connected as an Admin :
                                        ---------------------- */

Route::group(['middleware' => 'admin'], function() {

});