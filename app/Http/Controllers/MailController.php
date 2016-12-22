<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support;
use App\User;
use App\Tenant;
use App\Mail\ConfirmationMailTenant;
use App\Http\Requests;

class MailController extends Controller
{
    public function confirm($confirmation_code)
    {
        $user = User::where('confirmation_code','=',$confirmation_code)->first();

        if (!$user) {
            return \Redirect::to('index');
        }

        if(!\Auth::check()){
            \Auth::login($user);
        }
        if(!empty(Tenant::where('idPerson', '=', $user->idPerson)->first())){
            $user->status= 3;
            $user->confirmation_code = null;
            $user->save();
            return \Redirect::to('index');
        }
        else{
            $user->status= 1;
            $user->confirmation_code = null;
            $user->save();
            return \Redirect::to('index');
        }
    }

    public function SendConfirmationMail(){
        $user = User::find(\Auth::user()->idPerson);
        $user->status=0;
        $user->confirmation_code =str_random(40);
        $user->save();
        \Mail::to($user->email)->send(new ConfirmationMailTenant($user));
        return \Redirect::to('index');
    }
}
