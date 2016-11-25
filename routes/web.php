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
Route::get('confirmation/mail/{confirmationCode}','MailController@confirm');
Route::get('landlordCreateMail/{code}', 'LandlordController@verifyAccount');
Route::get('logoutfb', 'LoginController@logOutFb');
Route::get('logoutgoogle', 'LoginController@logOutGoogle');



/* ----------------------
                        Not connected :
                                        ---------------------- */
Route::group(['middleware' => 'guest'], function() {
    Route::post('login', 'LoginController@signIn');
    Route::post('signup', 'LoginController@signUp');


    Route::get('fbsignup', 'LoginController@signUpFacebook');
    Route::get('logingoogle', 'LoginController@signUpGoogle');


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

    /* ADD PROPERTY*/
        /*GET*/
    Route::get('add_property', 'LandlordController@showDetailsProperty');
    Route::get('definition_property', 'LandlordController@showDefinitionProperty');
    Route::get('definition_area', 'LandlordController@showDefinitionArea');
    Route::get('definition_estate', 'LandlordController@showDefinitionEstate');
    Route::get('definition_estate_shared', 'LandlordController@showDefinitionEstateShared');
    Route::get('final_preview', 'LandlordController@showFinalPreview');
    Route::get('update_estate_room' , 'LandlordController@showUpdateEstateRoom');

        /*POST*/
    Route::post('details_property', 'LandlordController@postDetailsProperty');
    Route::post('definition_property', 'LandlordController@postDefinitionProperty');
    Route::post('definition_area', 'LandlordController@postDefinitionArea');
    Route::post('definition_estate', 'LandlordController@postDefinitionEstate');
    Route::post('definition_estate_shared', 'LandlordController@postDefinitionEstateRoom');
    Route::post('update_estate_room', 'LandlordController@updateEstateRoom');

    /* AJAX */
    Route::get('get_area', 'LandlordController@getArea');
    Route::get('get_translation', 'LandlordController@getTranslation');
    Route::get('get_room' , 'LandlordController@getRoom');
    Route::get('get_delete', 'LandlordController@deleteEstate');

    Route::get('my_properties', 'LandlordController@showProperties');
    Route::get('my_booking', 'LandlordController@showBooking');
    Route::get('update_availabilities', 'LandlordController@showUpdateAvailabilities');
    Route::get('invoices', 'LandlordController@showInvoices');
    Route::get('messages', 'LandlordController@showMessages');

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