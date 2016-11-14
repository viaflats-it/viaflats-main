<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Landlord;
use App\User;
use Illuminate\support;
use Image;


class LandlordController extends Controller
{
    public function showAddProperty()
    {
        return view('landlord/add_property/details_properties');
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
        $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
        return view('landlord/profile_landlord', compact('landlord'));

    }


    public function disable()
    {

    }

    public function delete()
    {

    }

    public function updatePassword()
    {
        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);

        $validator = \Validator::make($formFields, [
            'actual_password' => 'required|min:5',
            'new_password' => 'required|min:5|confirmed|different:actual_password',
            'new_password_confirmation' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {

            if (\Hash::check($formFields['actual_password'], \Auth::user()->password)) {
                $user = User::find(\Auth::user()->idPerson);
                $user->password = \Hash::make($formFields['new_password']);
                $user->save();
            } else {
                $error = 'Wrong password';
                return \Response::json(array(
                    'fail' => true,
                    'errors_auth' => $error
                ));
            }
        }
    }

    public function updatePicture()
    {
        $user = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
        if (\Input::file('image')) {

            $image = \Input::file('image');
            $filename = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();

            $path = public_path('images/profiles/' . $filename);

            Image::make($image->getRealPath())->save($path);
            $user->profile_picture = $filename;
            $user->save();
        }

        return \Redirect::to('profile');

    }

    public function updateProfile()
    {
        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);
        $formFields['phone'] = \Input::get('phone');

        $validator = \Validator::make($formFields, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|unique:person,email,' . \Auth::user()->idPerson . ',idPerson',
            'phone' => 'required|regex:/[0-9]+/',
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $user = User::find(\Auth::user()->idPerson);
            $user->first_name = $formFields['first_name'];
            $user->last_name = $formFields['last_name'];
            $user->email = $formFields['email'];
            $user->phone = $formFields['phone'];
            $user->save();
        }
    }

    public function updateInformation()
    {


        $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();

        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);

        $userData = array(
            'about' => $formFields['about'],
            'company_web' => $formFields['company_web'],
            'contact_preference' => $formFields['contact_preference'],
            'corporate' => $formFields['corporate'],
        );

        $landlord->about = $userData['about'];
        $landlord->contact_preference = $userData['contact_preference'];
        $landlord->corporate = $userData['corporate'];
        $landlord->company_website = $userData['company_web'];
        $landlord->save();

//        }
    }

    public function verifyAccount($code)
    {
        $user = User::where('confirmation_code', '=', $code)->first();

        if (!$user) {
            return \Redirect::to('index')->withErrors('Error');
        }
        if (!\Auth::attempt(array('confirmation_code' => $code, 'password' => $code))) {
            return \Redirect::to('index')->withErrors('Error');
        }

        $user->status = 1;
        $user->save();

        return \Redirect::to('complete_profile');

    }

    public function completeProfile()
    {
        return view('landlord/complete_profile');
    }

    public function doCompleteProfile()
    {
        $validator = \Validator::make(\Input::all(), [
            'login' => 'required|min:5|unique:person',
            'password' => 'required|min:5|confirmed',
            'terms' => 'accepted'
        ]);

        if ($validator->fails()) {
            return \Redirect::to('complete_profile')->withErrors($validator);
        }

        $user = User::find(\Auth::user()->idPerson);

        $user->login = \Input::get('login');
        $user->password = \Hash::make(\Input::get('password'));

        $user->save();

        return \Redirect::to('profile');
    }


}
