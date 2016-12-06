<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
        /*----------------------------
                                        FORM
                                             ----------------------------*/
    'first_name' => 'First Name',
    'last_name' => 'Last name',
    'age' => 'Age',
    'email' => 'Email',
    'phone' => 'Phone',
    'login' => 'Log in',
    'changePassword' => 'Change password',
    'password' => 'Password',
    'password_confirmation' => 'Password Confirmation',
    'actual_password' => 'Actual password',
    'new_password' => 'New password',
    'new_password_confirmation' => 'New password confirmation',
    'moreInformation' => 'More information',
    'about' => 'About you',
    'contact_preference' => 'Contact preference',
    'none' => 'No preference',
    'availabilities' => 'Availabilities',
    'corporate' => 'Corporate',
    'paymentType' => 'Payment',
    'private' => 'Private',
    'company_web' => 'Company web site',
    'update' => 'Update',
    'send' => 'Send',
    'weekday' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    'read_accept' => 'I read and accept',
    'terms_condition' => 'Terms & Condition',
    'yes' => 'Yes',
    'no' => 'No',

            /*----------------------------
                                            MENU
                                                 ----------------------------*/

    'landlord' => 'Landlord',
    'profile' => 'Profile',
    'add_property' => 'Add a Property',
    'my_properties' => 'My Properties',
    'my_booking' => 'My Booking',
    'update_availabilities' => 'Update my availabilities',
    'invoices' => 'My Invoices',
    'messages' => 'Messages',
    'adminAddlandlord' => 'Add a Landlord',
    'minimize_label' => 'Minimize',
    'menu-toggle' => 'Toggle Menu',
    'absence' => 'Absences :',
    'absence_begin' => 'First day :',
    'absence_end' => 'Ending date :',
    'wrong_dates' => 'Selected dates are not correct',
    'monday' => 'Monday',
    'tuesday' => 'Tuesday',
    'wednesday' => 'Wednesday',
    'thursday' => 'Thursday',
    'friday' => 'Friday',
    'saturday' => 'Saturday',
    'sunday' => 'Sunday',
    'monday_availability' => 'Monday: ',
    'tuesday_availability' => 'Tuesday: ',
    'wednesday_availability' => 'Wednesday: ',
    'thursday_availability' => 'Thursday: ',
    'friday_availability' => 'Friday: ',
    'saturday_availability' => 'Saturday: ',
    'sunday_availability' => 'Sunday: ',
    'btnshow' => 'Show all',
    'btnhide' => 'Hide all',
    'fillall' => 'Fill all',
    'clearall' => 'Clear all',
    'cancelall' => 'Cancel all',
    'cancel' => 'Cancel',

                     /*----------------------------
                                             My Booking
                                                           ----------------------------*/

    'request_booking' => 'Booking request : ',
    'request_multiBooking' => 'MultiBooking request : ',
    'for' => 'for',
    'request_by' => 'Request By : ',
    'period' => 'Period : ',
    'days' => 'Number of days',
    'to' => 'to',
    'profit' => 'Profit : ',
    'guest' => 'Guest : ',
    'reject_booking' => 'Reject a booking',
    'select_reject_cause' => 'Please select the reason why you reject this booking',
    'reject_causes' => ['null'=>'Please Select One','Property already booked'=>'Property already booked','Dates don\'t fit' => 'Dates don\'t fit','other'=>'Other reason'],
    'submit' => 'Submit',
    'is_expired' => 'This booking is expired',
    'is_waiting' => 'You accept this booking ! You are now waiting for the payment from the tenant !',
    'is_waiting_multi' => 'You have changed the booking dates. You have to wait for the answer of the tenants !',
    'is_rejected' => 'You reject this booking',
    'is_confirmed' => 'This booking is confirmed. Contact the tenant to arrange his coming ! ',
    'is_confirmed_multi' => 'This booking is confirmed. Contact the tenants to arrange there coming ! ',
    'new_booking' => 'If the date don\'t fit you, you can send new dates for this booking to the tenant',
    'view_details' => 'View Details',
    'button_confirmed' => 'Confirm Request',
    'button_rejected' => 'Reject Request',
    'multiBookingCount' => 'Number of booking : ',
    'changeCheckout' => 'Change date of check out',
    'addComment' => 'You can add more info about you tenant : ',

                    /*----------------------------
                                             About the renter
                                                           ----------------------------*/

    'info_tenant' => 'Info about the Tenant ',
    'nationality' => 'Nationality',
    'studies' => 'Studies',
    'school' => 'School',
    'speaks' => 'Speaks',
    'about_renter' => 'About the renter',
    'budget' => 'Budget',
    'expected_city' => 'Want to live in ',
    'expected_in' => 'Expected check in ',
    'expected_out' => 'Expected check out',
    'more_info' => 'More Information',
    'more_info_advice' => 'You will be able to access these information when this booking will be confirmed and paid by the tenant',
    'full_address' => 'Full address',
    'mail_address' => 'Email address',
    'birth_date' => 'Birth date',
    'birth_place' => 'Birth place',
    'parent_name' => 'Parent name',
    'parent_address' => 'Parent address',
    'parent_phone' => 'Parent phone',
    'parent_mail' => 'Parent mail',



                    /*----------------------------
                                           ADD A PROPERTY
                                                         ----------------------------*/

    'details' => 'About the property',
    'type' => 'Property\'s type',
    'room_type'=> 'Room type, entire ou shared',
    'home' => 'Home',
    'shared' => 'Shared',
    'apartment' => 'Apartment',
    'studio' => 'Studio',
    'Tsize' => 'Total Size',
    'streetNumber' => 'Street Number',
    'street' => 'Street',
    'complement' => 'Complement',
    'zip' => 'Zip',
    'city' => 'City',
    'area' => 'Area',
    'country' => 'Country',
    'address' => 'Address',
    'wsarrond' => 'What\'s around',
    'needhelp' => 'Need help ?',
    'needHelpText' => 'We will be more than happy to assist you in fill this form. Please contact one of our Viaflats assistant.',
    'entire' => 'Entire',


                    /*----------------------------
                                           DEF A PROPERTY
                                                         ----------------------------*/

    'definition' =>  'Define your property',
    'living_room' => 'Living Room(s)',
    'bathroom' => 'Bathroom(s)',
    'bedroom' => 'Bedroom(s)',
    'toilet' => 'Toilet(s)',
    'laundry' => 'Laundry(s)',
    'basement' => 'Basement',
    'kitchen' => 'Kitchen',
    'number' => 'Number',
    'size' => 'Size',
    'furnished' => 'Furnished',
    'unfurnished' => 'Unfurnished',
    'shortStayExplication' => 'you can define the a short stay period and increase the price for this period',

                        /*----------------------------
                                               AMENITIES
                                                             ----------------------------*/

    'simple_bed' => 'Simple bed',
    'double_bed' => 'Double bed',
    'mattress' => 'Mattress',
    'desk' => 'Desk',
    'sink' => 'Sink',
    'heater' => 'Heater',
    'cupboard' => 'Cupboard',
    'towel' => 'Towel',
    'sofa' => 'Sofa',
    'bedside_lamp' => 'Bedside lamp',
    'mirror' => 'Mirror',
    'pillow' => 'Pillow',
    'fridge' => 'Fridge',
    'oven' => 'Oven',
    'chair' => 'Chair',
    'glass' => 'Glass',
    'dishwasher' => 'Dishwasher',
    'pot' => 'Pot',


                            /*----------------------------
                                                   FEES
                                                                 ----------------------------*/

    'city_fee' => 'City Fee',
    'cleaning_fee' => 'Cleaning Fee',
    'reservation_fee' => 'Reservation Fee',


];
