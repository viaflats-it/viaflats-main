<?php

namespace App\Http\Controllers;

use App\Foreign_booking;
use Illuminate\Http\Request;
use App\Property;
use App\Estate;
use App\Tenant;
use App\Room;
use App\Http\Requests;
use App\Fee;
use App\Restriction;

class PropertiesController extends Controller
{

    //Get the date from available
    public function getAvailableFrom($booking_date)
    {
        $booked_before = array();
        $available_date = "";
        foreach ($booking_date as $date) {
            if ($date > time()) {
                array_push($booked_before, $date);
            }
        }
        //Available From
        foreach ($booked_before as $booked) {
            foreach ($booked_before as $b) {
                if ($booked > $b) {
                    $available_date = $b;
                }
            }
        }

        return date('Y-m-d', $available_date);
    }

    public function ShowManageTenant()
    {

        $property = Property::find(\Input::get('ref'));
        $DCheckout = array();
        $Tenant = array();
        $status = array();
        $freeDate = array();
        $booking = array();
        $foreignB = array();
        $TypeTenant = array();
        //Get All Estate
        if ($property->rooms()->first() != '') {
            $rooms = $property->rooms()->get();
            foreach ($rooms as $room) {
                if ($room->estates()->first() != null) {
                    $estates[] = $room->estates()->first();
                }
            }
        } else {
            $estates[] = $property->estates()->first();
        }


        //Check Free / Booked Estate
        foreach ($estates as $estate) {
            $status[$estate->idEstate] = 'Free';
            if ($estate->booking_date != null) {
                foreach (unserialize($estate->booking_date) as $date) {
                    //Booked
                    if (date("Y-m-d", $date) == date("Y-m-d", time())) {
                        //Get Booking if booked
                        $bookings = $estate->booking()->get()->where('status', 'confirmed');
                        $status[$estate->idEstate] = 'hoi';
                        foreach ($bookings as $b) {
                            $day = PropertiesController::getDateBooked($b['checkin'], $b['checkout']);
                            foreach ($day as $d) {
                                if (date("Y-m-d", $date) == date("Y-m-d", $d)) {
                                    $status[$estate->idEstate] = 'Booked';
                                    //Get Checkout
                                    if ($b->real_checkout != null) {
                                        $DCheckout[$estate->idEstate] = $b->real_checkout;
                                    } else {
                                        $DCheckout[$estate->idEstate] = $b->checkout;
                                    }
                                    //Get tenant/User
                                    $TypeTenant[$estate->idEstate] = true;
                                    $Tenant[$estate->idEstate] = Tenant::find($b->idTenant)->person()->first();
                                    $booking[$estate->idEstate] = $b;
                                    break 3;
                                }
                            }
                        }

                        //Get Foreign Booking if booked and not by the website
                        $foreignBooking = $estate->foreign_booking()->get();
                        foreach ($foreignBooking as $fb) {
                            $day = PropertiesController::getDateBooked($fb['checkin'], $fb['checkout']);
                            foreach ($day as $d) {
                                if (date("Y-m-d", $date) == date("Y-m-d", $d)) {
                                    $status[$estate->idEstate] = 'Booked';
                                    //Get Checkout
                                    if ($fb->real_checkout != null) {
                                        $DCheckout[$estate->idEstate] = $fb->real_checkout;
                                    } else {
                                        $DCheckout[$estate->idEstate] = $fb->checkout;
                                    }
                                    $TypeTenant[$estate->idEstate] = false;
                                    $foreignB[$estate->idEstate] = $fb;
                                    break 3;
                                }
                            }
                        }
                    } else { //Free
                        if (PropertiesController::getAvailableFrom(unserialize($estate->booking_date)) != "") {
                            $status[$estate->idEstate] = 'Free until ';
                            $freeDate[$estate->idEstate] = PropertiesController::getAvailableFrom(unserialize($estate->booking_date));
                        } else {
                            $status[$estate->idEstate] = 'Free';
                        }
                    }
                }
            }
        }
        return view('landlord/edit_property/manage_tenant', compact('estates', 'status', 'DCheckout', 'Tenant', 'freeDate', 'booking', 'foreignB', 'TypeTenant'));
    }

    public function ShowManageProperty()
    {
        $property = Property::find(\Input::get('ref'));
        $bedroom = $property->rooms()->get()->where('idTypeRoom','3');

        //Get the title
        if ($property->type == 0) {
            $title = 'House ' . $property->address()->first()->street;
        } elseif ($property->type == 1) {
            $title = 'Apartment ' . $property->address()->first()->street;
        } else {
            $title = 'Studio ' . $property->address()->first()->street;
        }
        //Get all estate
        foreach ($bedroom as $room) {
            $roomLabel[$room->idRoom] = 'Bedroom '.$room->idRoom;
        }

        //Get all other rooms
        $rooms = $property->rooms()->get()->where('idTypeRoom','!=','3');
        foreach ($rooms as $room){
            $otherLabel[$room->idTypeRoom] = $room->type_room()->first();
        }

        return view('landlord/edit_property/manage_properties', compact('property', 'title', 'bedroom', 'roomLabel','otherLabel'));
    }

    //Get Info on a estate
    public function ShowInfoBedroom(){

        $room = Room::find(\Input::get('room'));
        $estate = $room->estates()->first();
        $amenities = $room->amenities()->get();
        return view("landlord/edit_property/show_bedroom",compact('room','estate','amenities'));

    }

    //Get Info on a room (type : Kitchen, bathroom, toilet ....)
    public function showInfoRoom(){
        $property = Property::find(\Input::get('id'));
        $rooms = $property->rooms()->get()->where('idTypeRoom',\Input::get('type'));
        foreach($rooms as $room){
            $title = $room->type_room()->first()->label;
            $amenities[$room->idRoom] = $room->amenities()->get();
        }
        return view('landlord/edit_property/show_other_room',compact('rooms','title','amenities'));
    }

    //Get Form for updating a estate
    public function showUpdateBedroom(){

        $typeRoom = \DB::table('type_room')->get();

        foreach ($typeRoom as $value) {
            if ($value->label == 'bedroom')
                $idBedroom = $value->idTypeRoom;

            if ($value->label == 'bathroom')
                $idBathRoom = $value->idTypeRoom;

            if ($value->label == 'toilet')
                $idToilet = $value->idTypeRoom;

            if ($value->label == 'kitchen')
                $idKitchen = $value->idTypeRoom;
        }

        $room = Room::find(\Input::get('bed'));
        $property = Property::find($room->property()->first()->idProperty);
        $estate = $room->estates()->first();
        $restrictions = Restriction::all();
        $type = "";
        $address = $property->address()->first();
        $area = $property->area()->first();
        $fees = Fee::all();
        if ($property->type == 0) {

            $type = trans('landlord.home');

        } elseif ($property->type == 1) {

            $type = trans('landlord.apartment');


        } elseif ($property->type == 2) {

            $type = trans('landlord.studio');

        }

        $feesEstate = array();
        $feesList = $estate->fees()->get();
        foreach ($feesList as $feeEstate) {
            $feesEstate[$feeEstate->idFee] = $feeEstate->pivot;
        }

        $restrictionsEstate = array();
        $restrictionsList = $estate->restrictions()->get();
        foreach ($restrictionsList as $restriction) {
            $restrictionsEstate[$restriction->idRestriction] = $restriction;
        }


        $roomLabel = $room->type_room()->first();
        $roomAmenities = $room->amenities()->get();
        $range_period = $estate->range_period;
        $privateRooms = array();
        foreach ($estate->privateRooms()->get() as $privateRoom) {
            switch ($privateRoom->idTypeRoom) {
                case $idBathRoom :
                    $privateRooms['bathroom'] = $privateRoom;
                    break;

                case $idToilet :
                    $privateRooms['toilet'] = $privateRoom;
                    break;

                case $idKitchen :
                    $privateRooms['kitchen'] = $privateRoom;
                    break;
            }
        }

        $rooms = $property->rooms()->get();

        foreach ($rooms as $singleRoom) {
            switch ($singleRoom->idTypeRoom) {
                case $idBathRoom :
                    $bathrooms[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idToilet :
                    $toilets[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idKitchen :
                    $kitchens[$singleRoom->idRoom] = $singleRoom->size;

            }
        }

        return view('landlord/edit_property/edit_bedroom', compact('kitchens', 'toilets', 'privateRooms', 'restrictionsEstate', 'feesEstate', 'estate', 'range_period', 'bathrooms', 'roomLabel', 'fees', 'roomAmenities', 'area', 'property', 'room', 'restrictions', 'type', 'address'));

    }

    public function showUpdateRoom(){
        $room = Room::find(\Input::get('room'));
        $amenities = $room->type_room()->first()->amenities()->get();
        $room_amenities = $room->amenities()->get();

        return view('landlord/edit_property/edit_room',compact('room','amenities','room_amenities'));
    }

    //Post Form for updating a estate
    public function updateBedroom(){

        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);

        $validator = \Validator::make($formFields, [
            'guest' => 'required|min:1|integer',
            'price' => 'required|min:1|numeric',
            'shortStay' => 'integer',
            'shortPrice' => 'numeric',
            'miniRent' => 'integer',
            'prefCheckin' => 'integer',
            'prefCheckout' => 'integer',
            'rentalSub' => 'integer',
            'bookingFlex' => 'integer',
            'glazing' => 'required',
            'windows' => 'required|min:0|integer',
            'disposition' => 'required',

        ]);
        if ($validator->fails()) {
            return \Redirect::to('definition_estate_shared?number=')->withErrors($validator);
        }

        $estate = Estate::find($formFields['idEstate']);

        $estate->guest_nb = $formFields['guest'];
        $estate->shared = $formFields['radioShared'] == null ? '0' : $formFields['radioShared'];
        $estate->rent = $formFields['price'];
        $estate->mini_stay = $formFields['miniRent'];
        $estate->booking_flexibility = $formFields['bookingFlex'];
        $estate->checkin_preference = $formFields['prefCheckin'];
        $estate->checkout_preference = $formFields['prefCheckout'];
        $estate->rental_sub = $formFields['rentalSub'];
        $estate->windows = $formFields['windows'];
        $estate->double_glazing = $formFields['glazing'];
        $estate->street_side = $formFields['disposition'];


        $range_period = array();
        for ($i = 0; $i < count($formFields['priceRange']); $i++) {
            $range_period[$i]['from'] = $formFields['from'][$i];
            $range_period[$i]['to'] = $formFields['to'][$i];
            $range_period[$i]['price'] = $formFields['priceRange'][$i];
        }

        $estate->restrictions()->detach();
        if (isset($formFields['restriction'])) {
            foreach ($formFields['restriction'] as $restriction) {
                $newRestriction = Restriction::find($restriction);

                $estate->restrictions()->save($newRestriction);
            }
        }
        $estate->range_period = serialize($range_period);

        $estate->privateRooms()->detach();

        if ($formFields['privateBathroom'] == 1) {
            $privateBathroom = Room::find($formFields['bathroomSize']);

            $estate->privateRooms()->save($privateBathroom);

        }

        if(isset($formFields['privateKitchen'])){
            if ($formFields['privateKitchen'] == 1) {
                $privateKitchen = Room::find($formFields['kitchenSize']);

                $estate->privateRooms()->save($privateKitchen);
            }
        }


        if ($formFields['privateToilet'] == 1) {
            $privateToilet = Room::find($formFields['toiletSize']);

            $estate->privateRooms()->save($privateToilet);
        }

        $estate->save();

        foreach ($formFields['priceFee'] as $key => $fee) {
            if ($fee > 0) {
                $newFee = Fee::find($key);

                if ( $formFields['slide'][$key] == "1") {
                    $monthly = 0;
                } else {
                    $monthly = 1;
                }

                if ($estate->fees()->where('Estate_fee.idFee', $key)->first() != null) {
                    $estate->fees()->updateExistingPivot($key, ['price' => $fee, 'monthly' => $monthly]);
                } else {
                    $estate->fees()->save($newFee, ['price' => $fee, 'monthly' => $monthly]);
                }
            }
        }
    }

    //Add a tenant who booked whitout Vialfats
    public function addTenant()
    {
        $inputData = \Input::get('data');
        parse_str($inputData, $TenantInfo);

        $validator = \Validator::make($TenantInfo, [
            'first_name' => 'required|alpha',
            'age' => 'required',
            'expected_in' => 'required|date',
            'expected_out' => 'required|date|after:expected_in'
        ]);


        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray(),
                'msg_error' => '',
            ));
        } else {
            $estate = Estate::find($TenantInfo['idEstate']);
            $booking_date = unserialize($estate->booking_date);
            if ($booking_date != null) { // Check if the estate is booked
                foreach ($booking_date as $date) {
                    if (strtotime($TenantInfo['expected_in']) == $date || strtotime($TenantInfo['expected_out']) == $date) {
                        return \Response::json(array(
                            'fail' => true,
                            'errors' => '',
                            'msg_error' => 'This Property is already Booked',
                        ));
                        break;
                    }
                }
                $bookedDays = PropertiesController::getDateBooked($TenantInfo['expected_in'], $TenantInfo['expected_out']);
                $booking_date = array_merge($booking_date, $bookedDays);
                $estate->booking_date = serialize($booking_date);
                $estate->save();
            } else {
                $bookedDays = PropertiesController::getDateBooked($TenantInfo['expected_in'], $TenantInfo['expected_out']);
                $estate->booking_date = serialize($bookedDays);
                $estate->save();
            }
            //New Foreign Booking
            $Fbooking = new Foreign_booking();
            $Fbooking->first_name = $TenantInfo['first_name'];
            $Fbooking->age = $TenantInfo['age'];
            $Fbooking->student = $TenantInfo['student'];
            $Fbooking->gender = $TenantInfo['gender'];
            $Fbooking->checkin = $TenantInfo['expected_in'];
            $Fbooking->checkout = $TenantInfo['expected_out'];
            $Fbooking->idEstate = $TenantInfo['idEstate'];
            $Fbooking->comment = $TenantInfo['comment'];
            $Fbooking->save();
            return $Fbooking;
        }
    }

    //Get all dates between 2 of them
    public function getDateBooked($dateIn, $dateOut)
    {
        $day = array(strtotime($dateIn));

        $numDay = abs(strtotime($dateIn) - strtotime($dateOut)) / 60 / 60 / 24;

        for ($i = 1; $i < $numDay + 1; $i++) {
            array_push($day, strtotime("+{$i} day", strtotime($dateIn)));
        }

        return $day;
    }

    //Get all the foreign booking for a estate
    public function showInfoForeignBooking()
    {
        $FBooking = Foreign_booking::find(\Input::get('idFB'));
        return [
            'FBooking' => $FBooking
        ];
    }

}
