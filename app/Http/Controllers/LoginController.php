<?php
namespace App\Http\Controllers;

session_start();


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

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withinput();
        }
        $confirmation_code = str_random(40);
        $user = User::create([
            'login' => \Input::get('login'),
            'password' => \Hash::make(\Input::get('password')),
            'first_name' => \Input::get('first-name'),
            'last_name' => \Input::get('last-name'),
            'email' => \Input::get('email'),
            'type_person' => \Input::get('type'),
            'confirmation_code' => $confirmation_code
        ]);

        if($user->type_person=0){
            \Mail::to(\Input::get('email'))->send(new ConfirmationMailTenant($user));
        }elseif ($user->type_person=1){
            \Mail::to(\Input::get('email'))->send(new ConfirmationMailLandlord($user));
        }



        if (\Auth::attempt(array('login' => \Input::get('login'), 'password' => \Input::get('password')))) {
            $id = \Auth::user()->idPerson;
            if (!empty(Tenant::where('idPerson', '=', $id)->first())) {
                return \Redirect::to('index');
            } elseif (!empty(Landlord::where('idPerson', '=', $id))) {
                return \Redirect::to('landlord');
            }
//            elseif (!empty(Photographer::where('idPerson', '=', $id)))
//            {
//                $user = Photographer::where('idPerson', '=', $id)->first();
//                return \Redirect::to('photographer');
//            }
        }
        return \Redirect::to('index');
    }

    public function signIn()
    {

        $validator = \Validator::make(\Input::all(), [
            'login' => 'required|alpha',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return \Redirect::to('index')->withErrors($validator)->withinput();
        }


        if (\Auth::attempt(array('login' => \Input::get('login'), 'password' => \Input::get('password')))) {
            $id = \Auth::user()->idPerson;

            if (!empty(Tenant::where('idPerson', '=', $id)->first())) {
                return \Redirect::to('index');
            } elseif (!empty(Landlord::where('idPerson', '=', $id))) {
                return \Redirect::to('landlord');
            }
//            elseif (!empty(Photographer::where('idPerson', '=', $id)))
//            {
//                $user = Photographer::where('idPerson', '=', $id)->first();
//                return \Redirect::to('photographer');
//            }
        }

        return \Redirect::to('index');
    }

    public function signUpFacebook()
    {
        $fb = new Facebook\Facebook(['app_id' => '220761998341263',
            'app_secret' => 'ed4cb1999a7d9ff37b4054c7befb282f',
            'default_graph_version' => 'v2.5',]);

        if (!isset($_SESSION['facebook_access_token'])) {
            $helper = $fb->getRedirectLoginHelper();
            try {
                $accessToken = $helper->getAccessToken();
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            if (isset($accessToken)) {
                // Logged in!
                $_SESSION['facebook_access_token'] = (string)$accessToken;

                // Now you can redirect to another page and use the
                // access token from $_SESSION['facebook_access_token']
            }

            $response = $fb->get('/me?fields=id,first_name, last_name,link,email,age_range', $_SESSION['facebook_access_token']);
            $userNode = $response->getGraphUser();
            $id = $userNode['id'];
        }

        if (!User::where('login', $userNode['id'])->first()) {
            User::create([
                'login' => $userNode['id'],
                'email' => $userNode['email'],
                'first_name' => $userNode['first_name'],
                'last_name' => $userNode['last_name'],
            ]);
        } else {
            $user = User::where('login', $userNode['id'])->first();
            if ($user->email != $userNode['email'])
                $user->email = $userNode['email'];
            if ($user->first_name != $userNode['first_name'])
                $user->first_name = $userNode['first_name'];
            if ($user->last_name != $userNode['last_name'])
                $user->last_name = $userNode['last_name'];
            $user->save();

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

    public function logOut()
    {
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
