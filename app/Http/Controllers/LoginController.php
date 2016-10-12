<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Landlord;
use App\Tenant;
use Illuminate\Support;
use App\User;

class LoginController extends Controller
{
    public function signUp()
{
    $validator = \Validator::make(\Input::all(), [
        'login' => 'required|alpha',
        'password' => 'required'
    ]);

    if ($validator->fails()){
        return \Redirect::to('/')->withErrors($validator)->withinput();
    }

    User::create([
        'login'=> \Input::get('login'),
        'password'=> \Hash::make(\Input::get('password'))
    ]);

    return \Redirect::to('/');
}
    public function signIn()
    {

        $validator = \Validator::make(\Input::all(), [
            'login' => 'required|alpha',
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return \Redirect::to('/')->withErrors($validator)->withinput();
        }


        if(\Auth::attempt(array('login' => \Input::get('login'), 'password' => \Input::get('password')))) {
            $id = \Auth::user()->idPerson;


            if (!empty(Tenant::where('idPerson', '=' ,$id)->first()))
            {
                return \Redirect::to('/');
            }
            elseif (!empty(Landlord::where('idPerson', '=', $id)))
            {
                return \Redirect::to('landlord');
            }
//            elseif (!empty(Photographer::where('idPerson', '=', $id)))
//            {
//                $user = Photographer::where('idPerson', '=', $id)->first();
//                return \Redirect::to('photographer');
//            }
        }

        return \Redirect::to('/');
    }


    public function forgotPassword()
    {

    }
    public function sendConfirmationMail()
    {

    }
    public function show()
    {

    }

    public function logOut(){
        \Auth::logout();
        return \Redirect::to('/');
    }
}
