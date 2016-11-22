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
Route::get('landlordCreateMail/{code}', 'LandlordController@verifyAccount');
Route::get('test', 'SearchController@test');
Route::post('search', 'SearchController@search');



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
    Route::get('landlord', 'LandlordController@showProfile');

    Route::get('profile', 'LandlordController@showProfile');
    Route::post('profile', 'LandlordController@updateProfile');

    Route::post('landlord_picture', 'LandlordController@updatePicture');
    Route::post('updatePassword', 'LandlordController@updatePassword');
    Route::post('updateInformation', 'LandlordController@updateInformation');

    Route::get('add_property', 'LandlordController@showAddProperty');
    Route::get('my_properties', 'LandlordController@showProperties');
    Route::get('my_booking', 'LandlordController@showBooking');
    Route::get('invoices', 'LandlordController@showInvoices');
    Route::get('messages', 'LandlordController@showMessages');

    Route::get('update_availabilities', 'LandlordController@showUpdateAvailabilities');
    Route::post('update_availabilities', 'LandlordController@updateAvailabilities');
    Route::post('update_absences', 'LandlordController@updateAbsences');

    Route::get('complete_profile' , 'LandlordController@completeProfile');
    Route::post('complete_profile' , 'LandlordController@doCompleteProfile');


});


/* ----------------------
                      connected as an Admin :
                                        ---------------------- */

Route::group(['middleware' => 'admin'], function() {
        Route::get('addLandlord', 'AdminController@showAddLandlord');
        Route::post('addLandlord', 'AdminController@doAddLandlord');
});
