<?php

namespace App\Http\Controllers;

use App\Landlord;
use App\User;
use App\Mail\AdminAddLandlord;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\support;

class AdminController extends Controller
{
    public function showAddLandlord()
    {
        return view('admin/addLandlord');
    }

    public function doAddLandlord()
    {
        $validator = \Validator::make(\Input::all(), [
            'email' => 'required|unique:person',
            'phone' => 'numeric',
            'phone_indicator' => 'numeric',
            'first_name' => 'alpha',
            'last_name' => 'alpha'
        ]);

        if($validator->fails())
        {
            return \Redirect::to('addLandlord')->withErrors($validator)->withinput();
        }

        $hash = \Input::get('email') . time();
        $code = md5($hash);
        $mdp = \Hash::make($code);

        $user = new User;
        $landlord = new Landlord;

        $user->create([
            'email' => \Input::get('email'),
            'phone' => \Input::get('phone'),
            'phone_indicator' => \Input::get('phone_indicator'),
            'first_name' => \Input::get('first_name'),
            'last_name' => \Input::get('last_name'),
            'confirmation_code' => $code,
            'password' => $mdp,
        ]);

        $user = User::where('confirmation_code', '=', $code)->first();

        $landlord->create([
            'idPerson' => $user->idPerson,
        ]);

        \Mail::to(\Input::get('email'))->send(new AdminAddLandlord($user));
        return \Redirect::to('addLandlord');
    }
}
