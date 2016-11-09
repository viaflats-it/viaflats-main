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
Route::get('SendConfirmationMail','MailController@SendConfirmationMail');


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
    Route::get('tenant','TenantController@showProfile');
    Route::get('profile','TenantController@showProfile');
    Route::get('account','PageController@account');

    //Account
    Route::post('updatePasswordTenant','TenantController@changePassword');
    Route::get('disable','TenantController@disable');
    Route::get('delete','TenantController@delete');

    //Update Profile
    Route::post('updatePlace','TenantController@updateBookingSearch');
    Route::post('updateAbout','TenantController@updateAboutYou');
    Route::post('updateTrustCenter','TenantController@updateTrustCenter');

    //First Step after mail confirm
    Route::post('uploadFiles', 'TenantController@uploadFiles');
    Route::get('deletePicture','TenantController@deletePicture');
    Route::get('FirstStepTenant','TenantController@FirstStepTenant');
    Route::get('FirstStepProperties','SearchController@FirstStepProperties');

    //Upload File Center
    Route::post('updateIdentity','TenantController@updateIdentity');
    Route::post('updateWorkAgreement','TenantController@updateWorkAgreement');
    Route::post('updateStudyAgreement','TenantController@updateStudyAgreement');
    Route::post('updatePaySlip','TenantController@updatePaySlip');
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