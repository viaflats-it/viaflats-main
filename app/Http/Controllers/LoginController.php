<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Landlord;
use App\Mail\ConfirmationMailTenant;
use App\Mail\ConfirmationMailLandlord;
use App\Tenant;
use Illuminate\Support;
use App\User;


use Facebook;

class LoginController extends Controller
{
    public function signUp()
    {
        $rules = array(
            'login' => 'required|max:255',
            'first-name' => 'required|max:255',
            'last-name' => 'required|max:255',
            'email' => 'required|email|unique:person,email|max:255',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'type' => 'required',
        );

        $message = array(
            'required' => 'The :attribute is required',
            'type.required' => 'You have to check one of this box',
            'accepted' => 'You have to accept the terms and conditions',
        );

        $validator = \Validator::make(\Input::all(), $rules, $message);

    if ($validator->fails()){
        return \Redirect::to('/')->withErrors($validator)->withinput();
    }

    User::create([
        'login'=> \Input::get('login'),
        'password'=> \Hash::make(\Input::get('password'))
    ]);

    return \Redirect::to('index');
}
    public function signIn()
    {
        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);


        $validator = \Validator::make($formFields, [
            'login' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {

            $loginChoice = filter_var($formFields['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
            if (\Auth::attempt(array($loginChoice => $formFields['login'], 'password' => $formFields['password']))) {
                $type = \Auth::user()->type_person;

                switch ($type) {
                    case 0:
                        return \Response::json(array(
                            'success' => true,
                            'url_return' => ['index']
                        ));
                        break;

                    case 1:
                        return \Response::json(array(
                            'success' => true,
                            'url_return' => ['landlord']
                        ));
                        break;

                    case 2:
                        return \Response::json(array(
                            'success' => true,
                            'url_return' => ['index']
                        ));
                        break;


                }
            }
            else
            {
                return \Response::json(array(
                    'fail' => true,
                    'errors' => [trans('auth.failed')]
                ));
            }
//            elseif (!empty(Photographer::where('idPerson', '=', $id)))
//            {
//                $user = Photographer::where('idPerson', '=', $id)->first();
//                return \Redirect::to('photographer');
//            }
        }

        return \Redirect::to('index');
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
        return \Redirect::to('index');
    }

    public function logOutFb()
    {
        \Auth::logout();
        $_SESSION['facebook_access_token'] = null;
        return \Redirect::to('index');
    }
}
