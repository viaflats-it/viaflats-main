<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class PageController extends Controller
{
    public function index()
    {
        if (\Auth::check())
        {
            $confirmed = false;
            if (\Auth::user()->confirmed) {
                $confirmed = true;
            }
        }
        return view('index', compact('confirmed'));
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
