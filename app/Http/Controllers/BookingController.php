<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Landlord;
use App\User;
use App\Booking;
use App\Booking_pack;
use App\City;
use App\Http\Requests;
use phpDocumentor\Reflection\Types\Null_;

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
        $countdown = array();
        foreach ($property as $p) {
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get();
                foreach ($book as $b) {
                    if (isset($b) && $b->idBookingPack == Null) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($estate, $v);
                        if ($b->status == 'pending') {
                            $count = BookingController::countdown($b->creation_date);
                            if ($count['status'] == 'expired') {
                                $b->status = 'expired';
                                $b->save();
                            } else {
                                $countdown[$b->idBooking] = $count;
                            }
                        } elseif ($b->status == 'waiting') {
                            $count = BookingController::countdown($b->confirm_date);
                            if ($count['status'] == 'expired') {
                                $b->status = 'expired';
                                $b->save();
                            } else {
                                $countdown[$b->idBooking] = $count;
                            }
                        }
                        array_push($booking, $b);
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
            'countdown' => $countdown,
        ];
    }

    public function countdown($date)
    {
        $diff = strtotime($date) + 48 * 60 * 60 - time();
        $return = array();
        $i_restantes = $diff / 60;
        $H_restantes = $i_restantes / 60;
        $d_restants = $H_restantes / 24;

        if ($diff < 0) {
            $return['status'] = 'expired';
        } else {
            $return['second'] = floor($diff % 60); // Secondes
            $return['min'] = floor($i_restantes % 60); // Minutes
            $return['hour'] = floor($H_restantes % 24); // Hour
            $return['day'] = floor($d_restants); // Days
            $return['status'] = 'notExpired';
        }
        return $return;
    }

    public function showPendingBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        $countdown = array();
        foreach ($property as $p) {
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get()->where('status', '=', 'pending');
                foreach ($book as $b) {
                    if (isset($b) && $b->idBookingPack == Null) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $v);
                        $countdown[$b->idBooking] = BookingController::countdown($b->creation_date);
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
            'countdown' => $countdown,
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
        $countdown = array();
        foreach ($property as $p) {
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get()->where('status', '=', 'waiting');
                foreach ($book as $b) {
                    if (isset($b) && $b->idBookingPack == Null) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $v);
                        $countdown[$b->idBooking] = BookingController::countdown($b->confirm_date);
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
            'countdown' => $countdown,
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
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get()->where('status', '=', 'confirmed');
                foreach ($book as $b) {
                    if (isset($b) && $b->idBookingPack == Null) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $v);
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
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get()->where('status', '=', 'rejected');
                foreach ($book as $b) {
                    if (isset($b) && $b->idBookingPack == Null) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $v);
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
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get()->where('status', '=', 'expired');
                foreach ($book as $b) {
                    if (isset($b) && $b->idBookingPack == Null) {
                        array_push($tenant, $b->tenant()->first());
                        array_push($person, $b->tenant()->first()->person()->first());
                        array_push($booking, $b);
                        array_push($estate, $v);
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
        $booking->confirm_date = date("Y-m-d h:i:s", time());
        $booking->save();
        return $booking;
    }

    public function cancelBooking()
    {

    }

    public function rejectBooking()
    {

        $Data = \Input::get('data');
        $newPack = new Booking_pack;
        $newBooking = new Booking;
        parse_str($Data, $rejectData);

        if ($rejectData['rejectcause'] == "Dates don't fit") {
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
            }
        }
        if ($rejectData['type'] == 'booking') {
            $booking = Booking::find($rejectData['idBooking']);
            $booking->rejection_cause = $rejectData['rejectcause'];
            if ($booking->rejection_cause == 'other') {
                $booking->rejection_cause_comment = $rejectData['comment'];
            } elseif ($booking->rejection_cause == "Dates don't fit") {
                $newBooking->idTenant = $booking->idTenant;
                $newBooking->checkin = $rejectData['expected_in'];
                $newBooking->checkout = $rejectData['expected_out'];
                $newBooking->status = 'waiting';
                $newBooking->idBookingPack = $booking->idBookingPack;
                $newBooking->booking_fee = $booking->booking_fee;
                $newBooking->idEstate = $booking->idEstate;
                $newBooking->idCode = $booking->idCode;
                $newBooking->guest = $booking->guest;
                $newBooking->confirm_date = date("Y-m-d h:i:s", time());
                $newBooking->save();
            }
            $booking->status = 'rejected';
            $booking->save();
        } else {
            $pack = Booking_pack::find($rejectData['idBooking']);
            $bookings = $pack->bookings()->get();
            foreach ($bookings as $booking) {
                $booking->rejection_cause = $rejectData['rejectcause'];
                if ($booking->rejection_cause == 'other') {
                    $booking->rejection_cause_comment = $rejectData['comment'];
                } elseif ($booking->rejection_cause == "Dates don't fit") {
                    $newBooking = new Booking;
                    $newPack->idTenant = $pack->idTenant;
                    $newPack->mails_list = $pack->mails_list;
                    $newPack->status = $pack->status;
                    $newPack->save();
                    $newBooking->idTenant = $booking->idTenant;
                    $newBooking->checkin = $rejectData['expected_in'];
                    $newBooking->checkout = $rejectData['expected_out'];
                    $newBooking->status = 'waiting';
                    $newBooking->idBookingPack = $newPack->idBookingPack;
                    $newBooking->booking_fee = $booking->booking_fee;
                    $newBooking->idEstate = $booking->idEstate;
                    $newBooking->idCode = $booking->idCode;
                    $newBooking->guest = $booking->guest;
                    $newBooking->confirm_date = date("Y-m-d h:i:s", time() + 60 * 60);
                    $newBooking->save();
                }
                $booking->status = 'rejected';
                $booking->save();
            }

        }
    }

    public function showMultiBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $status = \Input::get('status');
        $countdown = array();
        $pack = array();
        foreach ($property as $p) {
            if ($p->rooms()->first() != '') {
                $var = $p->rooms()->first()->estates()->first();

            } else {
                $var = $p->estates()->first();
            }
            if ($status != 'all') {
                $book = $var->booking()->get()->where('status', $status);
            } else {
                $book = $var->booking()->get();
            }
            if (!$book->isEmpty()) {
                foreach ($book as $b) {
                    if ($b->idBookingPack != Null) {
                        if ($b->status == 'pending') {
                            $count = BookingController::countdown($b->creation_date);
                            if ($count['status'] == 'expired') {
                                $b->status = 'expired';
                                $b->save();
                            } else {
                                $countdown[$b->idBookingPack] = $count;
                            }
                        } elseif ($b->status == 'waiting') {
                            $count = BookingController::countdown($b->confirm_date);
                            if ($count['status'] == 'expired') {
                                $b->status = 'expired';
                                $b->save();
                            } else {
                                $countdown[$b->idBookingPack] = $count;
                            }
                        }
                        $pack[$b->idBookingPack] = $b->bookingPack()->first();
                        $packEstate[$b->idBookingPack] = $b->estate()->first();
                        $packPerson[$b->idBookingPack] = $b->tenant()->first()->person()->first();
                        $bookingCount[$b->idBookingPack] = $b->bookingPack()->first()->bookings()->count();
                        $checkin[$b->idBookingPack] = $b->checkin;
                        $checkout[$b->idBookingPack] = $b->checkout;
                        $state[$b->idBookingPack] = $b->status;
                        if ($p->type == 0) {
                            $title[$b->idBookingPack] = 'House ' . $p->address()->first()->street;
                        } elseif ($p->type == 1) {
                            $title[$b->idBookingPack] = 'Apartment ' . $p->address()->first()->street;
                        } else {
                            $title[$b->idBookingPack] = 'Studio ' . $p->address()->first()->street;
                        }
                    }
                }
                usort($pack, array($this, 'compare'));
            }
        }

        if ($pack) {
            return [
                'empty' => false,
                'pack' => $pack,
                'estate' => $packEstate,
                'person' => $packPerson,
                'bookingCount' => $bookingCount,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'countdown' => $countdown,
                'title' => $title,
                'status' => $state,
            ];
        } else {
            return [
                'empty' => true,
            ];
        }
    }

    public function showInvoice()
    {

    }

    public function addBookingPack()
    {

    }

    public function DetailsBookingPack()
    {
        $pack = Booking_pack::find(\Input::get('idPack'));
        $bookings = $pack->bookings()->get();
        $estate = array();
        $person = array();
        foreach ($bookings as $b) {
            $estate[$b->idBooking] = $b->estate()->first();
            $person[$b->idBooking] = $b->tenant()->first()->person()->first();
        }
        return [
            'booking' => $bookings,
            'estate' => $estate,
            'person' => $person
        ];
    }

    public function confirmBookingPack()
    {
        $pack = Booking_pack::find(\Input::get('idPack'));
        $bookings = $pack->bookings()->get();
        foreach ($bookings as $b) {
            $b->status = 'confirmed';
            $b->save();
        }
    }

    function compare($a, $b)
    {
        return strcmp($b->creation_date, $a->creation_date);
    }

}
