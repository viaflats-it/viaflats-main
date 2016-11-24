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
            array_push($estate, $b->estate()->first());
        }
        return view('tenant/my_reservation',compact('booking','estate'));
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
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status', '=', 'waiting')->get()->sortByDesc('creation_date');
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
        return view('tenant/reservation-details',compact('booking','estate'));
    }

    public function deleteReservation()
    {
        $booking = Booking::find(\Input::get('ref'))->first();
        $booking->status = 'cancelled';
        $booking->save();
        \Redirect::to('my_reservation');
    }

    public function update()
    {

    }


}
