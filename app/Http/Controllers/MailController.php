<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support;
use App\User;
use App\Http\Requests;

class MailController extends Controller
{
    public function confirm($confirmation_code)
    {
        $user = User::where('confirmation_code','=',$confirmation_code)->first();
        if (!$user) {
            return \Redirect::to('index');
        }
        $user->status= 1;
        $user->confirmation_code = null;
        $user->save();
        if(!\Auth::check()){
            \Auth::login($user);
        }
        return \Redirect::to('index');
    }
}
