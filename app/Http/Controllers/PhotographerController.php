<?php

namespace App\Http\Controllers;

use App\Photographer;
use Illuminate\Http\Request;

class PhotographerController extends Controller
{
    public function showProfile()
    {
        return view('photographer/profile', compact('tableau'));
    }

    public function showAppointment()
    {

        return view('photographer/my_appointment');
    }

    public function showAvailabilities()
    {
        return view('photographer/my_availabilities');
    }
}
