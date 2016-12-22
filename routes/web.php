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
Route::get('test', 'SearchController@test');
Route::post('search', 'SearchController@search');


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
    Route::get('/home', 'HomeController@index');
    Route::get('logoutfb', 'LoginController@logOutFb');
    Route::get('fbsignup', 'LoginController@signUpFacebook');
    Route::get('logingoogle', 'LoginController@signUpGoogle');
    Route::get('logoutgoogle', 'LoginController@logOutGoogle');


    //Account
    Route::post('updatePasswordTenant','TenantController@changePassword');
    Route::get('disable','TenantController@disable');
    Route::get('delete','TenantController@delete');

    //Update Profile
    Route::post('updatePlace','TenantController@updateBookingSearch');
    Route::post('updateAbout','TenantController@updateAboutYou');
    Route::post('updateTrustCenter','TenantController@updateTrustCenter');
    Route::post('DeleteTagTenant','TenantController@DeleteTagTenant');

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

    //Reservation
    Route::get('my_reservation','ReservationController@showMyReservation');
    Route::get('showAllReservation','ReservationController@showAll');
    Route::get('showPending','ReservationController@showPendingReservation');
    Route::get('showWaiting','ReservationController@showWaitingReservation');
    Route::get('showConfirmed','ReservationController@showConfirmedReservation');
    Route::get('showRejected','ReservationController@showRejectedReservation');
    Route::get('showExpired','ReservationController@showExpiredReservation');
    Route::get('reservation-details','ReservationController@showInfoReservation');
    Route::get('DeleteReservation','ReservationController@deleteReservation');
});


/* ----------------------
                         connected as a Landlord :
                                        ---------------------- */
Route::group(['middleware' => 'landlord'], function() {
    Route::get('landlord', 'LandlordController@showProfile');

    Route::get('profile_landlord', 'LandlordController@showProfile');
    Route::post('profile_landlord', 'LandlordController@updateProfile');

    Route::post('landlord_picture', 'LandlordController@updatePicture');
    Route::post('updatePassword', 'LandlordController@updatePassword');
    Route::post('updateInformation', 'LandlordController@updateInformation');

    /* ADD PROPERTY*/

        /*GET*/
        /*All the process */
    Route::get('add_property', 'LandlordController@showDetailsProperty');
    Route::get('definition_property', 'LandlordController@showDefinitionProperty');
    Route::get('definition_area', 'LandlordController@showDefinitionArea');
    Route::get('definition_area_studio', 'LandlordController@showDefinitionAreaStudio');
    Route::get('definition_estate', 'LandlordController@showDefinitionEstate');
    Route::get('definition_estate_shared', 'LandlordController@showDefinitionEstateShared');
    Route::get('final_preview', 'LandlordController@showFinalPreview');
    /* end of the process */

    Route::get('update_estate_room', 'LandlordController@showUpdateEstateRoom');
    Route::get('appointment' , 'LandlordController@appointment');

        /*POST*/
    Route::post('details_property', 'LandlordController@postDetailsProperty');
    Route::post('definition_property', 'LandlordController@postDefinitionProperty');
    Route::post('definition_area', 'LandlordController@postDefinitionArea');
    Route::post('definition_estate', 'LandlordController@postDefinitionEstate');
    Route::post('definition_estate_shared', 'LandlordController@postDefinitionEstateRoom');
    Route::post('update_estate_room', 'LandlordController@updateEstateRoom');
    Route::post('update_property', 'LandlordController@updateProperty');
    Route::post('delete_estate', 'LandlordController@deleteEstate');
    Route::post('activate_estate', 'LandlordController@activateEstate');
    Route::post('delete_room', 'LandlordController@deleteRoom');
    Route::post('update_room', 'LandlordController@updateRoom');


    /* AJAX */
    Route::get('get_area', 'LandlordController@getArea');
    Route::get('get_translation', 'LandlordController@getTranslation');
    Route::get('get_room', 'LandlordController@getRoom');

    Route::get('my_properties', 'LandlordController@showProperties');
    Route::get('my_booking', 'LandlordController@showBooking');
    Route::get('update_availabilities', 'LandlordController@showUpdateAvailabilities');
    Route::post('update_availabilities', 'LandlordController@updateAvailabilities');
    Route::get('invoices', 'LandlordController@showInvoices');
    Route::get('messages', 'LandlordController@showMessages');

    Route::get('complete_profile', 'LandlordController@completeProfile');
    Route::post('complete_profile', 'LandlordController@doCompleteProfile');

    /* BOOKING */
    Route::get('showMyBooking','BookingController@showMyBooking');
    Route::get('showPendingBooking','BookingController@showPendingBooking');
    Route::get('showWaitingBooking','BookingController@showWaitingBooking');
    Route::get('showConfirmedBooking','BookingController@showConfirmedBooking');
    Route::get('showRejectedBooking','BookingController@showRejectedBooking');
    Route::get('showExpiredBooking','BookingController@showExpiredBooking');
    Route::get('showInfoTenant','BookingController@showInfoTenant');
    Route::get('confirmBooking','BookingController@confirmBooking');
    Route::post('rejectBooking','BookingController@rejectBooking');
    Route::get('DetailsBookingPack','BookingController@DetailsBookingPack');
    Route::get('confirmBookingPack','BookingController@confirmBookingPack');
    Route::get('showMultiBooking','BookingController@showMultiBooking');

    /* MANAGE TENANT */
    Route::get('manageTenant','PropertiesController@ShowManageTenant');
    Route::post('addTenant','PropertiesController@addTenant');
    Route::post('changeCheckout','BookingController@changeCheckout');
    Route::get('showInfoForeignBooking','PropertiesController@showInfoForeignBooking');



});


/* ----------------------
                         connected as a Photographer :
                                        ---------------------- */
Route::group(['middleware' => 'photographer'], function () {
    Route::get('photographer', 'PhotographerController@showProfile');
    Route::get('profile', 'PhotographerController@showProfile');
    Route::get('my_appointment', 'PhotographerController@showAppointment');
    Route::get('my_availabilities', 'PhotographerController@showAvailabilities');
});


/* ----------------------
                      connected as an Admin :
                                        ---------------------- */

Route::group(['middleware' => 'admin'], function () {
    Route::get('addLandlord', 'AdminController@showAddLandlord');
    Route::post('addLandlord', 'AdminController@doAddLandlord');
});