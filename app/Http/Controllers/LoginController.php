<?php
namespace App\Http\Controllers;

session_start();


use App\Http\Requests;
use App\Landlord;
use App\Tenant;
use Illuminate\Support;
use App\User;

use Facebook;
use Google_Client;
use Google_Service_Oauth2;

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

    public function signUpGoogle()
    {
        $client = new Google_Client();
        $client->setAuthConfig('..\config\credentials.json');
        $client->setScopes(['profile', 'email']);
        $client->setAccessType('offline');
        $client->setApplicationName('Viaflats');

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['google_access_token'] = $client->getAccessToken();
            //var_dump($client->getAccessToken());
        }

        $client->setAccessToken($_SESSION['google_access_token']);

        $oauth = new Google_Service_Oauth2($client);
        $picture = $oauth->userinfo->get()->picture;
        $fname = $oauth->userinfo->get()->givenName;
        $lname = $oauth->userinfo->get()->familyName;
        $email = $oauth->userinfo->get()->email;
        $id = $oauth->userinfo->get()->id;


        //Creates the user or modifies it if the user changed his google data since the last connection
        if(!User::where('email', $email)->first())
        {
            User::create([
                'login' => $id,
                'email'=> $email,
                'password' => \Hash::make('google_'.$email.$fname.$lname),
                'profile_picture' => $picture,
                'first_name' => $fname,
                'last_name' => $lname,
                ]);
        }
        else
        {

            if(User::where('login', $id)->first())
            {
                $user=User::where('login', $id)->first();
            }
            else
            {
                $user=User::where('email', $email)->first();
                $user->login = $id;
            }

            if($user->email != $email)
                $user->email = $email;
            if($user->first_name != $fname)
                $user->first_name = $fname;
            if($user->last_name != $lname)
                $user->last_name = $lname;
            if($user->profile_picture != $picture)
                $user->profile_picture = $picture;
            $user->password = \Hash::make('google_'.$email.$fname.$lname);
            $user->save();

        }
        \Auth::attempt(['login' => $id, 'password' => 'google_'.$email.$fname.$lname]);
        //Once finished, return to index
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
        if(!User::where('email', $userNode['email'])->first())
        {
            User::create([
                'login' => $userNode['id'],
                'email'=> $userNode['email'],
                'password' => \Hash::make('facebook_'.$userNode['email'].$userNode['first_name'].$userNode['last_name']),
                'profile_picture' => 'http://graph.facebook.com/'.$userNode['id'].'/picture',
                'first_name' => $userNode['first_name'],
                'last_name' => $userNode['last_name'],
                ]);
        }
        else
        {
            if(User::where('login', $userNode['id'])->first())
            {
                $user=User::where('login', $userNode['id'])->first();
            }
            else
            {
                $user=User::where('email', $userNode['email'])->first();
                $user->login = $userNode['id'];
            }
                if($user->email != $userNode['email'])
                    $user->email = $userNode['email'];
                if($user->first_name != $userNode['first_name'])
                    $user->first_name = $userNode['first_name'];
                if($user->last_name != $userNode['last_name'])
                    $user->last_name = $userNode['last_name'];
                if($user->profile_picture != 'http://graph.facebook.com/'.$userNode['id'].'/picture')
                    $user->profile_picture = 'http://graph.facebook.com/'.$userNode['id'].'/picture';
            $user->password = \Hash::make('facebook_'.$userNode['email'].$userNode['first_name'].$userNode['last_name']);
            $user->save();

        }
        \Auth::attempt(['login' => $userNode['id'], 'password' => 'facebook_'.$userNode['email'].$userNode['first_name'].$userNode['last_name']]);
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
    $_SESSION['facebook_access_token'] = null;
    $_SESSION['google_access_token'] = null;
    return \Redirect::to('index');
}

public function logOutFb(){
    \Auth::logout();
    //Destroying the session
    $_SESSION['facebook_access_token'] = null;
    return \Redirect::to('index');
}

public function logOutGoogle(){
    \Auth::logout();
    //Destroying the session
    $_SESSION['google_access_token'] = null;
    return \Redirect::to('index');
}
}
