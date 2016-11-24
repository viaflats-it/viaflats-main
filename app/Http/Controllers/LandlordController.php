<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Landlord;
use App\User;
use App\Booking;
use App\Payment_way;
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
        return view('landlord/add_property');
    }

    public function showProperties()
    {
        return view('landlord/my_properties');

    }

    function compare($a, $b) {
        return strcmp($b->creation_date,$a->creation_date);
    }

    public function showBooking()
    {

        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $estate = array();
        $booking = array();
        $tenant = array();
        $person = array();
        $numberDays = array();
        foreach ($property as $p) {
            if($p->rooms()->first() !=''){
                $var = $p->rooms()->first()->estates()->first();
                array_push($estate,$var);

            }else{
                $var = $p->estates()->first();
                array_push($estate,$var);
            }
            $book = $var->booking()->get();
            foreach ($book as $b){
                array_push($tenant,$b->tenant()->first());
                array_push($person,$b->tenant()->first()->person()->first());
                $checkin = $b->checkin;
                $checkout = $b->checkout;
                $daysTimestamp =  $checkout - $checkin;
                $days = $daysTimestamp/(60*60*24);
                array_push($booking,$b);
                array_push($numberDays,$days);
            }
        }
        usort($booking, array($this,'compare'));
        $tenant = array_unique($tenant);
        $estate = array_unique($estate);
        $person = array_unique($person);
        return view('landlord/my_booking', compact('estate','booking','tenant','person','numberDays'));
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

        $payment = array();
        foreach (Payment_way::all() as $p) {
            $payment[$p->idPayment] = $p->label;
        }
        $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $land_payment = array();
        foreach ($landlord->payment_way()->get() as $p) {
            array_push($land_payment, $p->idPayment);
        }
        return view('landlord/profile_landlord', compact('landlord', 'payment', 'land_payment'));

    }

    public function showUpdateAvailabilities()
    {
        return view('landlord/update_availabilities');

    }

    public function updateAvailabilities()
    {
        $week=array();

        for($i=0; $i<24; $i++)
        {
            $week["monday_".$i]=\Input::all()["monday_".$i];
            $week["tuesday_".$i]=\Input::all()["tuesday_".$i];
            $week["wednesday_".$i]=\Input::all()["wednesday_".$i];
            $week["thursday_".$i]=\Input::all()["thursday_".$i];
            $week["friday_".$i]=\Input::all()["friday_".$i];
            $week["saturday_".$i]=\Input::all()["saturday_".$i];
            $week["sunday_".$i]=\Input::all()["sunday_".$i];
        }
        $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $array=serialize($week);
        $landlord->contact_time = $array;
        $landlord->save();
        return \Redirect::to('profile');
    }

    public function updateAbsences()
    {
        $rules = ['absence_begin' => 'required', 'absence_end' => 'required'];
        $inputData = ['absence_begin' => \Input::get('absence_begin'), 'absence_end' => \Input::get('absence_end')];

        $validator = \Validator::make(\Input::all(), $rules);


        if ($validator->fails()) {
            return \Redirect::to('update_availabilities')->withErrors($validator);
        }
        else {
            $datebegin = strtotime($inputData['absence_begin']);
            $dateend = strtotime($inputData['absence_end']);
            $today = strtotime(date('Y-m-d'));
            if($datebegin>$dateend || $datebegin<$today)
            {
                $validator->errors()->add('wrong', trans('landlord.wrong_dates'));
                return \Redirect::to('update_availabilities')->withErrors($validator);
            }
            $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
            $array=serialize(['first_day' => $inputData['absence_begin'], 'last_day' => $inputData['absence_end']]);
            $landlord->contact_away = $array;
            $landlord->save();
        }
        return \Redirect::to('profile');
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

    public function updatePicture(){

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
        if (isset($formFields['payment_way'])) {
            $landlord->payment_way()->sync($formFields['payment_way']);
        } else {
            $landlord->payment_way()->detach();
        }
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
