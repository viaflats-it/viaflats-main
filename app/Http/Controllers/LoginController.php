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

        if ($validator->fails()) {
            return \Redirect::to('/')->withErrors($validator)->withinput();
        }

        User::create([
            'login' => \Input::get('login'),
            'password' => \Hash::make(\Input::get('password'))
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

        }
    }

    public
    function forgotPassword()
    {

    }

    public
    function sendConfirmationMail()
    {

    }

    public
    function show()
    {

    }

    public
    function logOut()
    {
        \Auth::logout();
        return \Redirect::to('index');
    }
}
