<?php

namespace App\Http\Controllers;

use App\Foreign_booking;
use Illuminate\Http\Request;
use App\Property;
use App\Estate;
use App\Tenant;
use App\Http\Requests;

class PropertiesController extends Controller
{
    public function show()
    {

    }

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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
        return view('landlord/manage_tenant', compact('estates', 'status', 'DCheckout', 'Tenant', 'freeDate', 'booking', 'foreignB', 'TypeTenant'));
    }

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
            if ($booking_date != null) {
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
            }else{
                $bookedDays = PropertiesController::getDateBooked($TenantInfo['expected_in'], $TenantInfo['expected_out']);
                $estate->booking_date = serialize($bookedDays);
                $estate->save();
            }
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

    public function getDateBooked($dateIn, $dateOut)
    {
        $day = array(strtotime($dateIn));

        $numDay = abs(strtotime($dateIn) - strtotime($dateOut)) / 60 / 60 / 24;

        for ($i = 1; $i < $numDay + 1; $i++) {
            array_push($day, strtotime("+{$i} day", strtotime($dateIn)));
        }

        return $day;
    }

    public function showInfoForeignBooking()
    {
        $FBooking = Foreign_booking::find(\Input::get('idFB'));
        return [
            'FBooking' => $FBooking
        ];
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function addProperty()
    {

    }

    public function addRoom()
    {

    }


}
