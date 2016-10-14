<?php
namespace App\Http\Controllers;

session_start();


use App\Http\Requests;
use App\Landlord;
use App\Tenant;
use Illuminate\Support;
use App\User;

use Facebook;

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

        return \Redirect::to('index');
    }
    public function signIn()
    {

        $validator = \Validator::make(\Input::all(), [
            'login' => 'required|alpha',
            'password' => 'required'
            ]);

        if ($validator->fails()){
            return \Redirect::to('index')->withErrors($validator)->withinput();
        }


        if(\Auth::attempt(array('login' => \Input::get('login'), 'password' => \Input::get('password')))) {
            $id = \Auth::user()->idPerson;

            if (!empty(Tenant::where('idPerson', '=' ,$id)->first()))
            {
                return \Redirect::to('index');
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

        return \Redirect::to('index');
    }

    public function signUpFacebook()
    {

        //To change if the used app changes
        $fb = new Facebook\Facebook(['app_id' => '220761998341263',
            'app_secret' => 'ed4cb1999a7d9ff37b4054c7befb282f',
            'default_graph_version' => 'v2.5',]);
        
        //Get the token after the user clicked on the button
        //Displays errors
        if(!isset($_SESSION['facebook_access_token']))
        {
          $helper = $fb->getRedirectLoginHelper();
          try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        //Put the token into a session variable
        if (isset($accessToken)) {
            // Logged in!
            $_SESSION['facebook_access_token'] = (string) $accessToken;

            // Now you can redirect to another page and use the
            // access token from $_SESSION['facebook_access_token']
        }

        //Get user data
        $response = $fb->get('/me?fields=id,first_name, last_name,link,email,age_range', $_SESSION['facebook_access_token']);
        $userNode = $response->getGraphUser();
        $id=$userNode['id'];

    //Creates the user or modifies it if the user changed his facebook data since the last connection
        if(!User::where('login', $userNode['id'])->first())
        {
            User::create([
                'login' => $userNode['id'],
                'email'=> $userNode['email'],
                'first_name' => $userNode['first_name'],
                'last_name' => $userNode['last_name'],
                ]);
        }
        else
        {
            $user=User::where('login', $userNode['id'])->first();
            if($user->email != $userNode['email'])
                $user->email = $userNode['email'];
            if($user->first_name != $userNode['first_name'])
                $user->first_name = $userNode['first_name'];
            if($user->last_name != $userNode['last_name'])
                $user->last_name = $userNode['last_name'];
            $user->save();

        }
        \Auth::attempt(array('login' => $id, 'password' => null));

    }
    //Once finished, return to index
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

public function logOutFb(){
    \Auth::logout();
    //Destroying the session
    $_SESSION['facebook_access_token'] = null;
    return \Redirect::to('index');
}
}
