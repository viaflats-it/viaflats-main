<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Estate;
use App\Tenant;
use App\User;
use App\Http\Requests;

class ReservationController extends Controller
{
    public function showMyReservation()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->get()->sortByDesc('creation_date');
        $estate = array();
        foreach ($booking as $b) {
            $estate[$b->idBooking] = $b->estate()->first();
            if ($b->status == 'waiting') {
                $count = ReservationController::countdown($b->confirm_date);
                if ($count['status'] == 'expired') {
                    $b->status = 'expired';
                    $b->save();
                } else {
                    $countdown[$b->idBooking] = $count;
                }
            }
        }
        return view('tenant/my_reservation', compact('booking', 'estate', 'countdown'));
    }

    public function countdown($date)
    {
        $diff = strtotime($date) + 48 * 60 * 60 - time() - 3600;
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

    public function showPendingReservation()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status', '=', 'pending')->get()->sortByDesc('creation_date');
        $estate = array();
        foreach ($booking as $b) {
            array_push($estate, $b->estate()->first());
        }

        return [
            'booking' => $booking,
            'estate' => $estate,
        ];
    }

    public function showWaitingReservation()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status', 'waiting')->get()->sortByDesc('creation_date');
        $estate = array();
        foreach ($booking as $b) {
            array_push($estate, $b->estate()->first());
        }

        return [
            'booking' => $booking,
            'estate' => $estate,
        ];
    }

    public function showConfirmedReservation()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status', '=', 'confirmed')->get()->sortByDesc('creation_date');
        $estate = array();
        foreach ($booking as $b) {
            array_push($estate, $b->estate()->first());
        }

        return [
            'booking' => $booking,
            'estate' => $estate,
        ];
    }

    public function showRejectedReservation()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status', '=', 'rejected')->get()->sortByDesc('creation_date');
        $estate = array();
        foreach ($booking as $b) {
            array_push($estate, $b->estate()->first());
        }

        return [
            'booking' => $booking,
            'estate' => $estate,
        ];
    }

    public function showExpiredReservation()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status', '=', 'expired')->get()->sortByDesc('creation_date');
        $estate = array();
        foreach ($booking as $b) {
            array_push($estate, $b->estate()->first());
        }

        return [
            'booking' => $booking,
            'estate' => $estate,
        ];
    }

    public function showInfoReservation()
    {
        $id = \Input::get('ref');
        $booking = Booking::find($id);
        $estate = $booking->estate()->first();
        return view('tenant/reservation-details', compact('booking', 'estate'));
    }

    public function deleteReservation()
    {
        $booking = Booking::find(\Input::get('ref'))->first();
        $booking->status = 'cancelled';
        $booking->save();
        \Redirect::to('my_reservation');
    }

    //Don't forget when tenant pay to add the dates to booking_dates in estate
    public function waitingBooking()
    {

    }

    public function update()
    {

    }


}
