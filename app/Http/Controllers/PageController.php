<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class PageController extends Controller
{
    public function index()
    {
        $confirmed = false;
        $first_tenant = false;
        if (\Auth::check())
        {
            $confirmed = false;
            $first_tenant = false;
            if (\Auth::user()->confirmed) {
                $confirmed = true;
            }
            if (\Auth::user()->status == 3) {
                $first_tenant = true;
            }
        }
        return view('index', compact('confirmed','first_tenant'));
    }

    public function landlord(){
        return view('landlord/profil_landlord');
    }

    public function tenant(){
        return view('tenant/profile_tenant');
    }

    public function account(){
        return view('tenant/account');
    }
}
