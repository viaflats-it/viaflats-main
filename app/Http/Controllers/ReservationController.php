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
        return view('tenant/my_reservation');
    }

    public function showAll()
    {
        $booking = User::find(\Auth::user()->idPerson)->tenant()->first()->booking()->where('status','=','pending')->get();
        $estate = array();
        foreach ($booking as $b) {
            array_push($estate, $b->estate()->first());
        }
        return [
            $booking,
            $estate,
        ];
    }

    public function showPending()
    {

    }

    public function showWaiting()
    {

    }

    public function showConfirmed()
    {

    }

    public function showRejected()
    {

    }

    public function delete()
    {

    }

    public function update()
    {

    }

}
