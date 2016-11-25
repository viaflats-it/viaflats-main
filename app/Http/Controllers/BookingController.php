<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Landlord;
use App\User;
use App\Booking;
use App\City;
use App\Http\Requests;

class BookingController extends Controller
{
    public function showMyBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();
                $book = $var->booking()->get();
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            } else {
                $var = $p->estates()->first();
                $book = $var->booking()->get();
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            }
        }
        usort($booking, array($this, 'compare'));
        return [
            'booking' => $booking,
            'estate' => $estate,
            'tenant' => $tenant,
            'person' => $person,
        ];
    }

    public function showPendingBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'pending');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            } else {
                $var = $p->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'pending');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            }
        }
        usort($booking, array($this, 'compare'));
        return [
            'booking' => $booking,
            'estate' => $estate,
            'tenant' => $tenant,
            'person' => $person,
        ];
    }

    public function showWaitingBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'waiting');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            } else {
                $var = $p->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'waiting');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            }
        }
        usort($booking, array($this, 'compare'));
        return [
            'booking' => $booking,
            'estate' => $estate,
            'tenant' => $tenant,
            'person' => $person,
        ];
    }

    public function showConfirmedBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'confirmed');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            } else {
                $var = $p->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'confirmed');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            }
        }
        usort($booking, array($this, 'compare'));
        return [
            'booking' => $booking,
            'estate' => $estate,
            'tenant' => $tenant,
            'person' => $person,
        ];
    }

    public function showRejectedBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'rejected');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            } else {
                $var = $p->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'rejected');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            }
        }
        usort($booking, array($this, 'compare'));
        return [
            'booking' => $booking,
            'estate' => $estate,
            'tenant' => $tenant,
            'person' => $person,
        ];
    }

    public function showExpiredBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'expired');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            } else {
                $var = $p->estates()->first();
                $book = $var->booking()->get()->where('status', '=', 'expired');
                foreach ($book as $b) {
                    if (isset($b)) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $var);
                    }
                }
            }
        }
        usort($booking, array($this, 'compare'));
        return [
            'booking' => $booking,
            'estate' => $estate,
            'tenant' => $tenant,
            'person' => $person,
        ];
    }

    public function showInfoTenant()
    {
        $booking = Booking::find(\Input::get('idBooking'));
        $person = User::find(\Input::get('idP'));
        $tenant = $person->tenant()->first();
        $parent = $tenant->parent()->first();
        $city = City::find($tenant->expected_city)->libelle;
        $address = $tenant->address()->first();
        $address_p = $parent->address()->first();
        return [
            'person' => $person,
            'tenant' => $tenant,
            'expected_city' => $city,
            'booking' => $booking->status,
            'address' => $address,
            'address_p' => $address_p,
            'parent' => $parent,
        ];
    }

    public function addBooking()
    {

    }

    public function confirmBooking()
    {
        $booking = Booking::find(\Input::get('idBooking'));
        $booking->status = 'waiting';
        $booking->save();
        return $booking;
    }

    public function cancelBooking()
    {

    }

    public function rejectBooking()
    {

        $Data = \Input::get('data');
        $newBooking = new Booking;
        parse_str($Data, $rejectData);

        $rules = array(
            'expected_in' => 'required|date|after:today',
            'expected_out' => 'required|date|after:expected_in'
        );
        $validator = \Validator::make($rejectData, $rules);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $booking = Booking::find($rejectData['idBooking']);
            $booking->rejection_cause = $rejectData['rejectcause'];
            if ($booking->rejection_cause == 'other') {
                $booking->rejection_cause_comment = $rejectData['comment'];
            } elseif ($booking->rejection_cause == "Dates don't fit") {
                $newBooking->idTenant = $booking->idTenant;
                $newBooking->checkin = $rejectData['expected_in'];
                $newBooking->checkout = $rejectData['expected_out'];
                $newBooking->status = 'pending';
                $newBooking->idBookingPack = $booking->idBookingPack;
                $newBooking->booking_fee = $booking->booking_fee;
                $newBooking->idEstate = $booking->idEstate;
                $newBooking->idCode = $booking->idCode;
                $newBooking->guest = $booking->guest;
                $newBooking->save();
            }
            $booking->status = 'rejected';
            $booking->save();
            return [
                $rejectData,
                $booking,
                $newBooking,
            ];
        }
    }

    public function showInvoice()
    {

    }

    public function addBookingPack()
    {

    }

    function compare($a, $b)
    {
        return strcmp($b->creation_date, $a->creation_date);
    }

}
