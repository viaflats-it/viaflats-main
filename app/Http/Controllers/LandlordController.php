<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Landlord;
use App\User;
use Illuminate\support;
use Image;


class LandlordController extends Controller
{
    public function showAddProperty()
    {
        return view('landlord/add_property');
    }

    public function showProperties()
    {
        return view('landlord/my_properties');

    }

    public function showBooking()
    {
        return view('landlord/my_booking');

    }

    public function showUpdateAvailabilities()
    {
        return view('landlord/update_availabilities');

    }

    public function showInvoices()
    {
        return view('general/invoices');

    }

    public function showMessages()
    {
        return view('general/messages');

    }

    public function showProfile()
    {
        $weekday = trans('landlord.weekday');

        $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
        return view('landlord/profile_landlord', compact('landlord' , 'weekday'));

    }


    public function disable()
    {

    }

    public function delete()
    {

    }

    public function updatePassword()
    {
        $validator = \Validator::make(\Input::all(), [
            'actual_password' => 'required|min:5',
            'new_password' => 'required|min:5|confirmed|different:Apassword',
            'new_password_confirmation' => 'required|min:5'
        ]);

        if ($validator->fails())
        {
            return \Redirect::to('profile#changePassword')->withErrors($validator);
        }

        $now_password   = \Input::get('Apassword');
        $check = \Hash::check($now_password, \Auth::user()->password);

        if(\Hash::check($now_password, \Auth::user()->password)){
                $user = User::find(\Auth::user()->idPerson);
                $user->password = \Hash::make(\Input::get('new_password'));
                $user->save();
            return \Redirect::to('profile');

        }
        else {
            return \Redirect::to('profile#changePassword')->withErrors(array('ApassWrong' => 'Mot de passe incorrect'));
        }


    }

    public function updatePicture()
    {
        $user = Landlord::where('idPerson','=',\Auth::user()->idPerson)->first();
        if(\Input::file('image'))
        {

            $image = \Input::file('image');
            $filename  = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();

            $path = public_path('profilepics/' . $filename);

            Image::make($image->getRealPath())->save($path);
            $user->profile_picture = $filename;
            $user->save();
        }

        return \Redirect::to('profile');

    }

    public function updateProfile()
    {
        $validator = \Validator::make(\Input::all(), [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|unique:person,email,'.\Auth::user()->idPerson.',idPerson',
            'phone_indicator' => 'required|numeric',
            'phone' => 'required|numeric',
            'login' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return \Redirect::to('profile')->withErrors($validator)->withinput();
        }

        $user = User::find(\Auth::user()->idPerson);

        $user->first_name = \Input::get('first_name');
        $user->last_name = \Input::get('last_name');
        $user->email = \Input::get('email');
        $user->phone_indicator = \Input::get('phone_indicator');
        $user->phone = \Input::get('phone');
        $user->login = \Input::get('login');

        $user->save();

        return \Redirect::to('profile');
    }

    public function updateInformation()
    {

        $validator = \Validator::make(\Input::all(), [
            'about' => 'min:2'
        ]);
        if ($validator->fails())
        {
            return \Redirect::to('profile#moreInformation')->withErrors($validator);
        }


        $landlord = Landlord::where('idPerson', '=',\Auth::user()->idPerson)->first();

        $landlord->about = \Input::get('about');
        $landlord->contact_preference = \Input::get('contact_preference');
        $landlord->corporate = \Input::get('corporate');
        $landlord->company_website = \Input::get('company_web');
        $landlord->save();

        return \Redirect::to('profile#moreInformation');
    }

}
