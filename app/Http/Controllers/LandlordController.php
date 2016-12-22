<?php

namespace App\Http\Controllers;

use App\Address;
use App\Address_list;
use App\Amenities;
use App\Estate;
use App\Fee;
use App\Property;
use App\Restriction;
use App\Room;
use App\Http\Requests;
use App\Landlord;
use App\User;
use App\Payment_way;
use Illuminate\support;
use Illuminate\Support\Facades\Input;
use Image;
use App\City;
use App\Area;
use App\Booking_pack;
use App\Type_room;
use App\Tenant;
use App\ParentTenant;


class LandlordController extends Controller
{
    public function showDetailsProperty()
    {
        $City = City::pluck('libelle', 'idCity')->all(); //get all cities

        if (\Session::get('idProperty')) {  //if an property already exist in this session
            $property = Property::find(\Session::get('idProperty'));
            $address = $property->address()->first();
        }

        return view('landlord/add_property/details_property', compact('City', 'property', 'address'));
    }

    public function showDefinitionProperty()
    {
        $piecesList = Type_room::where('label', '!=', 'studio')->pluck('label', 'idTypeRoom')->map(function ($pieces) {
            return trans(sprintf('landlord.%s', $pieces));
        })->toArray();

        $pieces = Type_room::all();

        $fields = ['number', 'size', 'furnished'];
        return view('landlord/add_property/def_prop', compact('piecesList', 'pieces', 'fields', 'ID'));
    }

    public function showDefinitionAreaStudio()
    {
        if (!\Session::has('idProperty')) {
            return \Redirect::to('add_property');
        }

        $property = Property::find(\Session::get('idProperty'));
        $amenities = Amenities::all();
        return view('landlord/add_property/def_area_studio', compact('property', 'amenities'));
    }

    public function showDefinitionArea()
    {

        if (!\Input::has('number')) {
            return \Redirect::to('definition_area?number=0');
        } elseif (!\Session::has('idProperty')) {
            return \Redirect::to('add_property');
        }
        $redirect = "";
        $numb = \Input::get('number');
        $property = Property::find(\Session::get('idProperty'));

        $idBedRoom = Type_room::where('label' , 'bedroom')->first()->idTypeRoom;

        if ($property->shared == 1) {
            $rooms = $property->rooms->where('idTypeRoom', '!=', $idBedRoom);
            $key = 0;
            foreach ($rooms as $room) {
                if ($room != null) {
                    $roomArray[$key] = $room;
                    $key++;
                }
            }
            $redirect = 'definition_estate_shared?number=0';
        } else {
            $roomArray = $property->rooms;
            $redirect = 'definition_estate';
        }


        if (isset($roomArray[$numb])) {
            $room = $roomArray[$numb];
        } else {
            return \Redirect::to($redirect);
        }

        $typeRoom = $room->type_room()->first();
        $amenities = $typeRoom->amenities()->get();

        return view('landlord/add_property/def_area', compact('room', 'typeRoom', 'amenities', 'numb'));



    }

    public function showDefinitionEstate()
    {
//        $property = Property::find(\Session::get('idProperty'));
        $property = Property::find(\Session::get('idProperty'));

        $typeRoom = \DB::table('type_room')->get();

        foreach ($typeRoom as $value) {
            if ($value->label == 'bedroom')
                $idBedroom = $value->idTypeRoom;

            if ($value->label == 'bathroom')
                $idBathRoom = $value->idTypeRoom;

            if ($value->label == 'toilet')
                $idToilet = $value->idTypeRoom;

            if ($value->label == 'kitchen')
                $idKitchen = $value->idTypeRoom;
        }


        $restrictions = Restriction::all();
        $type = "";
        $address = $property->address()->first();
        $area = $property->area()->first();
        $fees = Fee::all();
        if ($property->type == 0) {

            $type = trans('landlord.home');

        } elseif ($property->type == 1) {

            $type = trans('landlord.apartment');


        } elseif ($property->type == 2) {

            $type = trans('landlord.studio');

        }

        $rooms = $property->rooms()->get();

        foreach ($rooms as $value) {
            $roomsLabel[$value->idRoom] = $value->type_room()->first();
            $roomsAmenities[$value->idRoom] = $value->amenities()->get();
        }


        foreach ($rooms as $singleRoom) {
            switch ($singleRoom->idTypeRoom) {
                case $idBathRoom :
                    $bathrooms[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idToilet :
                    $toilets[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idKitchen :
                    $kitchens[$singleRoom->idRoom] = $singleRoom->size;

            }
        }

        return view('landlord/add_property/def_estate', compact('roomsAmenities','roomsLabel','kitchens', 'toilets', 'privateRooms', 'restrictionsEstate', 'feesEstate', 'estate', 'range_period', 'bathrooms', 'roomLabel', 'fees', 'roomAmenities', 'area', 'property', 'rooms', 'restrictions', 'type', 'address'));

    }

    public function showDefinitionEstateShared()
    {
//      $property = Property::find(\Session::get('idProperty'));
        $property = Property::find(\Session::get('idProperty'));
        $numb = \Input::get('number');
        $typeRoom = \DB::table('type_room')->get();

        foreach ($typeRoom as $value) {
            if ($value->label == 'bedroom')
                $idBedroom = $value->idTypeRoom;

            if ($value->label == 'bathroom')
                $idBathRoom = $value->idTypeRoom;

            if ($value->label == 'toilet')
                $idToilet = $value->idTypeRoom;

            if ($value->label == 'kitchen')
                $idKitchen = $value->idTypeRoom;
        }

        $rooms = $property->rooms()->get();
        $roomEstate = $property->rooms()->where('idTypeRoom', '=', $idBedroom)->get();

        if (isset($roomEstate[$numb])) {
            $room = $roomEstate[$numb];
        } else {
            return \Redirect::to('final_preview');
        }


        $restrictions = Restriction::all();
        $type = "";
        $address = $property->address()->first();
        $area = $property->area()->first();
        $fees = Fee::all();
        if ($property->type == 0) {

            $type = trans('landlord.home');

        } elseif ($property->type == 1) {

            $type = trans('landlord.apartment');


        } elseif ($property->type == 2) {

            $type = trans('landlord.studio');

        }


        foreach ($rooms as $value) {
            $roomsLabel[$value->idRoom] = $value->type_room()->first();
            $roomsAmenities[$value->idRoom] = $value->amenities()->get();
        }


        foreach ($rooms as $singleRoom) {
            switch ($singleRoom->idTypeRoom) {
                case $idBathRoom :
                    $bathrooms[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idToilet :
                    $toilets[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idKitchen :
                    $kitchens[$singleRoom->idRoom] = $singleRoom->size;

            }
        }


        return view('landlord/add_property/def_estate_shared', compact('toilets','kitchens','bathrooms', 'numb', 'roomsLabel', 'rooms', 'fees', 'roomsAmenities', 'area', 'property', 'room', 'restrictions', 'type', 'address'));


    }

    public function showUpdateEstateRoom()
    {
        $property = Property::find(\Session::get('idProperty'));

        $typeRoom = \DB::table('type_room')->get();

        foreach ($typeRoom as $value) {
            if ($value->label == 'bedroom')
                $idBedroom = $value->idTypeRoom;

            if ($value->label == 'bathroom')
                $idBathRoom = $value->idTypeRoom;

            if ($value->label == 'toilet')
                $idToilet = $value->idTypeRoom;

            if ($value->label == 'kitchen')
                $idKitchen = $value->idTypeRoom;
        }


        $room = Room::find(\Input::get('id'));

        $estate = $room->estates()->first();
        $restrictions = Restriction::all();
        $type = "";
        $address = $property->address()->first();
        $area = $property->area()->first();
        $fees = Fee::all();
        if ($property->type == 0) {

            $type = trans('landlord.home');

        } elseif ($property->type == 1) {

            $type = trans('landlord.apartment');


        } elseif ($property->type == 2) {

            $type = trans('landlord.studio');

        }

        $feesEstate = array();
        $feesList = $estate->fees()->get();
        foreach ($feesList as $feeEstate) {
            $feesEstate[$feeEstate->idFee] = $feeEstate->pivot;
        }

        $restrictionsEstate = array();
        $restrictionsList = $estate->restrictions()->get();
        foreach ($restrictionsList as $restriction) {
            $restrictionsEstate[$restriction->idRestriction] = $restriction;
        }


        $roomLabel = $room->type_room()->first();
        $roomAmenities = $room->amenities()->get();
        $range_period = $estate->range_period;
        $privateRooms = array();
        foreach ($estate->privateRooms()->get() as $privateRoom) {
            switch ($privateRoom->idTypeRoom) {
                case $idBathRoom :
                    $privateRooms['bathroom'] = $privateRoom;
                    break;

                case $idToilet :
                    $privateRooms['toilet'] = $privateRoom;
                    break;

                case $idKitchen :
                    $privateRooms['kitchen'] = $privateRoom;
                    break;
            }
        }


        $rooms = $property->rooms()->get();

        foreach ($rooms as $singleRoom) {
            switch ($singleRoom->idTypeRoom) {
                case $idBathRoom :
                    $bathrooms[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idToilet :
                    $toilets[$singleRoom->idRoom] = $singleRoom->size;
                    break;

                case $idKitchen :
                    $kitchens[$singleRoom->idRoom] = $singleRoom->size;

            }
        }

        return view('landlord/add_property/update_estate_room', compact('kitchens', 'toilets', 'privateRooms', 'restrictionsEstate', 'feesEstate', 'estate', 'range_period', 'bathrooms', 'roomLabel', 'fees', 'roomAmenities', 'area', 'property', 'room', 'restrictions', 'type', 'address'));


    }

    public function showFinalPreview()
    {
        $property = Property::find(\Session::get('idProperty'));
        $property = Property::find(13);

        if ($property->type == 0) {

            $type = trans('landlord.home');

        } elseif ($property->type == 1) {

            $type = trans('landlord.apartment');

        } elseif ($property->type == 2) {

            $type = trans('landlord.studio');

        }

        $roomEstateList = collect();
        $estatesList = collect();

        if ($property->estates()->first()) {
            $estate = $property->estates()->first();
        } else {
            $property->rooms->each(function ($room) use ($estatesList, $roomEstateList) {
                if (!empty($room->estates[0])) {
                    $estatesList->push($room->estates);
                    $roomEstateList[$room->idRoom] = $room;
                }
            });
        }

        $typeRoom = \DB::table('type_room')->get();

        foreach ($typeRoom as $value) {
            if ($value->label == 'bedroom')
                $idBedroom = $value->idTypeRoom;

            if ($value->label == 'bathroom')
                $idBathRoom = $value->idTypeRoom;
        }


        $address = $property->address()->first();
        $rooms = $property->rooms()->get();
        $countInfo = ['bedroom' => 0, 'bathroom' => 0];
        $countBedroom = 1;
        $countBathroom = 1;

        foreach ($rooms as $room) {


            $room->idTypeRoom == $idBedroom ? $countInfo['bedroom'] = $countBedroom++ : '';
            $room->idTypeRoom == $idBathRoom ? $countInfo['bathroom'] = $countBathroom++ : '';

            $roomsLabel[$room->idRoom] = $room->type_room()->first();
            $roomsAmenities[$room->idRoom] = $room->amenities()->get();
        }

//        return $estatesList;
        return view('landlord/preview', compact('idBedroom', 'roomEstateList', 'property', 'type', 'rooms', 'address', 'countInfo', 'roomsLabel', 'roomsAmenities', 'estatesList', 'estate'));
    }

    public function appointment()
    {
        $property = Property::find(\Session::get('idProperty'));

        $property->status = true;
        $property->save();

        $city = City::find($property->area()->first()->idCity);
        $photographers = $city->photographers()->get();

        foreach ($photographers as $photographer) {
            $blop = unserialize($photographer->availabilities);


            if (is_array($blop) || is_object($blop)) {
                foreach ($blop as $key => $value) {
                    $date[$key] = $value['date'];
                }
            }


        }
        return view('landlord/add_property/appointment', compact('city', 'property', 'date'));
    }

    function showProperties()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $properties = $landlord->property()->get();
        foreach ($properties as $property) {
            //Get Title
            if ($property->type == 0) {
                $title[$property->idProperty] = 'House ' . $property->address()->first()->street;
            } elseif ($property->type == 1) {
                $title[$property->idProperty] = 'Apartment ' . $property->address()->first()->street;
            } else {
                $title[$property->idProperty] = 'Studio ' . $property->address()->first()->street;
            }
            //Get City
            $prop_city[$property->idProperty] = $property->address()->first()->city;
            //Get Area
            $prop_area[$property->idProperty] = $property->area()->first()->label;

            //Count estate foreach
            if ($property->rooms()->first() != '') {
                $nbEstate[$property->idProperty] = $property->rooms()->get()->count();
                $picture[$property->idProperty] = $property->rooms()->first()->estates()->first()->picture;
            } else {
                $nbEstate[$property->idProperty] = $property->estates()->get()->count();
                $picture[$property->idProperty] = $property->estates()->first()->picture;
            }
        }
        return view('landlord/my_properties', compact('properties', 'prop_city', 'title', 'prop_area', 'nbEstate', 'picture'));

    }

    public function compare($a, $b)
    {
        return strcmp($b->creation_date, $a->creation_date);
    }

    public function countdown($date)
    {
        $diff = strtotime($date) + 48 * 60 * 60 - time();
        $return = array();
        $i_restantes = $diff / 60;
        $H_restantes = $i_restantes / 60;
        $d_restants = $H_restantes / 24;

        if ($diff < 0) {
            $return['status'] = 'expired';
        } else {
            $return['second'] = floor($diff % 60); // Secondes
            $return['min'] = floor($i_restantes % 60); // Minutes
            $return['hour'] = floor($H_restantes % 24); // Hour
            $return['day'] = floor($d_restants); // Days
            $return['status'] = 'notExpired';
        }
        return $return;
    }

    public function showBooking()
    {
        $landlord = User::find(\Auth::user()->idPerson)->landlord()->first();
        $property = $landlord->property()->get();
        $booking = array();
        $pack = array();
        foreach ($property as $p) {
            $var = array();
            if ($p->rooms()->first() != '') {
                $rooms = $p->rooms()->get();
                foreach ($rooms as $room) {
                    if ($room->estates()->first() != null) {
                        $var[] = $room->estates()->first();
                    }
                }
            } else {
                $var[] = $p->estates()->first();
            }
            foreach ($var as $v) {
                $book = $v->booking()->get();
                foreach ($book as $b) {
                    //Countdown
                    if ($b->status == 'pending') {
                        $count = LandlordController::countdown($b->creation_date);
                        if ($count['status'] == 'expired') {
                            $b->status = 'expired';
                            $b->save();
                        } else {
                            $countdown[$b->idBooking] = $count;
                        }
                    } elseif ($b->status == 'waiting') {
                        $count = LandlordController::countdown($b->confirm_date);
                        if ($count['status'] == 'expired') {
                            $b->status = 'expired';
                            $b->save();
                        } else {
                            $countdown[$b->idBooking] = $count;
                        }
                    }

                    //Multi-booking
                    if ($b->idBookingPack != null) {
                        $pack[$b->idBookingPack] = $b->bookingPack()->first();
                        $packEstate[$b->idBookingPack] = $b->estate()->first();
                        $packPerson[$b->idBookingPack] = $b->tenant()->first()->person()->first();
                        $bookingCount[$b->idBookingPack] = $b->bookingPack()->first()->bookings()->count();
                        $checkin[$b->idBookingPack] = $b->checkin;
                        $checkout[$b->idBookingPack] = $b->checkout;
                        $status[$b->idBookingPack] = $b->status;
                        if ($p->type == 0) {
                            $title[$b->idBookingPack] = 'House ' . $p->address()->first()->street;
                        } elseif ($p->type == 1) {
                            $title[$b->idBookingPack] = 'Apartment ' . $p->address()->first()->street;
                        } else {
                            $title[$b->idBookingPack] = 'Studio ' . $p->address()->first()->street;
                        }
                    } else {
                        $booking[$b->idBooking] = $b;
                        $estate[$b->idBooking] = $v;
                        $person[$b->idBooking] = $b->tenant()->first()->person()->first();
                    }
                }
            }
        }
        usort($pack, array($this, 'compare'));
        if ($booking) {
            usort($booking, array($this, 'compare'));
        }
        return view('landlord/my_booking', compact('estate', 'booking', 'person', 'countdown', 'packEstate', 'pack', 'packPerson', 'bookingCount', 'checkin', 'checkout', 'title', 'status'));
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

    public function updateAvailabilities()
    {
        $week = array();

        for ($i = 0; $i < 24; $i++) {
            $week["monday_" . $i] = \Input::all()["monday_" . $i];
            $week["tuesday_" . $i] = \Input::all()["tuesday_" . $i];
            $week["wednesday_" . $i] = \Input::all()["wednesday_" . $i];
            $week["thursday_" . $i] = \Input::all()["thursday_" . $i];
            $week["friday_" . $i] = \Input::all()["friday_" . $i];
            $week["saturday_" . $i] = \Input::all()["saturday_" . $i];
            $week["sunday_" . $i] = \Input::all()["sunday_" . $i];
        }
        $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $array = serialize($week);
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
        } else {
            $datebegin = strtotime($inputData['absence_begin']);
            $dateend = strtotime($inputData['absence_end']);
            $today = strtotime(date('Y-m-d'));
            if ($datebegin > $dateend || $datebegin < $today) {
                $validator->errors()->add('wrong', trans('landlord.wrong_dates'));
                return \Redirect::to('update_availabilities')->withErrors($validator);
            }
            $landlord = Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
            $array = serialize(['first_day' => $inputData['absence_begin'], 'last_day' => $inputData['absence_end']]);
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

    /* MANAGE LANDLORD PROFILE */
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


    /* MANAGE ADD PROPERTY */

    public function postDetailsProperty()
    {
//        return \Input::all();
        $validator = \Validator::make(\Input::all(), [
            'type' => 'required',
            'room_type' => 'required',
            'Tsize' => 'required',
            'streetNumber' => 'required|integer',
            'street' => 'required',
            'zip' => 'required|alpha_num',
            'city' => 'required',
//            'area' => 'required',
            'country' => 'required'
            // 'wsarrond' => 'required',
        ]);

        if ($validator->fails()) {
            return \Redirect::to('add_property')->withErrors($validator)->withinput();
        }

        if (\Session::get('idProperty')) {
            $property = Property::find(\Session::get('idProperty'));
        } else {
            $property = new Property();
            $property->idLandlord = \Auth::user()->landlord()->first()->idLandlord;
        }

        $property->type = \Input::get('type');
        $property->shared = \Input::get('room_type');
        $property->idArea = \Input::get('area');
        $property->size = \Input::get('Tsize');


        $address = New Address();
        $address->street_number = \Input::get('streetNumber');
        $address->street = \Input::get('street');
        $address->complement = \Input::get('complement');
        $address->zip = \Input::get('zip');
        $address->city = \Input::get('city');
        $address->country = \Input::get('country');


        $address->save();
        $address->property()->save($property);

        \Session::put('idProperty', $property->idProperty);


        if ($property->type == 2) {
            $idStudio = Type_room::where('label', 'studio')->first()->idTypeRoom;

            $room = new Room();
            $room->size = $property->size;
            $room->idTypeRoom = $idStudio;

            $property->rooms()->save($room);

            return \Redirect::to('definition_area?number=0');
        } else {
            return \Redirect::to('definition_property');
        }
    }

    public function postDefinitionProperty()
    {
//       return \Input::all();
        $property = Property::find(\Session::get('idProperty'));
        $numberValue = \Input::get('number');
        $count = 0;

        foreach ($numberValue as $key => $value) {

            if ($value > 0) {

                $size = \Input::get('size.' . $key);
//                return $size;

                foreach ($size as $idSize => $sizeValue) {
                    $count++;
                    $room = New Room();
                    $room->size = $sizeValue;
//                    $room->furnished = \Input::get('furnished-' . $key);
                    $room->idTypeRoom = $key;
                    $property->rooms()->save($room);
                }
            }
        }
        return \Redirect::to('definition_area?number=0');

    }

    public function postDefinitionArea()
    {
        $rules = [
            'numb' => 'integer',
            'amenities' => 'required'
        ];

        $validator = \Validator::make(\Input::all(), $rules);

        if ($validator->fails()) {
            return \Redirect::to('definition_area?number=' . \Input::get('numb'))->withErrors($validator)->withInput();
        }

        $room = Room::find(\Input::get('room'));

        $room->amenities()->detach();
        foreach (\Input::get('amenities') as $amenity) {
            $new = Amenities::find($amenity);
            $number = \Input::get('number');
            $room->amenities()->save($new, ['number' => $number[$amenity]]);
        }
        $numbPage = \Input::get('numb');
        $numbPage++;
        return \Redirect::to('definition_area?number=' . $numbPage);

    }

    public function postDefinitionEstate()
    {
//        return \Input::all();
        $validator = \Validator::make(\Input::all(), [
            'guest' => 'required|min:1|integer',
            'price' => 'required|min:1|numeric',
            'shortStay' => 'integer',
            'shortPrice' => 'numeric',
            'miniRent' => 'integer',
            'prefCheckin' => 'integer',
            'prefCheckout' => 'integer',
            'rentalSub' => 'integer',
            'bookingFlex' => 'integer',
            'glazing' => 'required',
            'windows' => 'required|min:0|integer',
            'disposition' => 'required',
        ]);

        if ($validator->fails()) {
            return \Redirect::to('definition_estate')->withErrors($validator);
        }

        $estate = New Estate();
        $property = Property::find(\Session::get('idProperty'));

        $estate->guest_nb = \Input::get('guest');
        $estate->shared = \Input::get('radioShared') == null ? '0' : \Input::get('radioShared');
        $estate->rent = \Input::get('price');
        $estate->mini_stay = \Input::get('miniRent');
        $estate->booking_flexibility = \Input::get('bookingFlex');
        $estate->checkin_preference = \Input::get('prefCheckin');
        $estate->checkout_preference = \Input::get('prefCheckout');
        $estate->rental_sub = \Input::get('rentalSub');
        $estate->windows = \Input::get('windows');
        $estate->double_glazing = \Input::get('glazing');
        $estate->street_side = \Input::get('disposition');
        $estate->furnished = \Input::get('furnished');

        $range_period = array();
        for ($i = 0; $i < count(\Input::get('priceRange')); $i++) {
            $range_period[$i]['from'] = \Input::get('from.' . $i);
            $range_period[$i]['to'] = \Input::get('to.' . $i);
            $range_period[$i]['price'] = \Input::get('priceRange.' . $i);
        }

        $estate->range_period = serialize($range_period);


        $property->estates()->save($estate);


        $estate->restrictions()->detach();
        if (\Input::get('restriction') != null) {
            foreach (\Input::get('restriction') as $restriction) {
                $newRestriction = Restriction::find($restriction);


                $estate->restrictions()->save($newRestriction);

            }
        }


        foreach (\Input::get('priceFee') as $key => $fee) {
            if ($fee > 0) {
                $newFee = Fee::find($key);

                if (\Input::get('slide.' . $key) == "1") {
                    $monthly = 0;
                } else {
                    $monthly = 1;
                }

                if ($estate->fees()->where('Estate_fee.idFee', $key)->first() != null) {
                    $estate->fees()->updateExistingPivot($key, ['price' => $fee, 'monthly' => $monthly]);
                } else {
                    $estate->fees()->save($newFee, ['price' => $fee, 'monthly' => $monthly]);
                }
            }
        }

        return \Redirect::to('final_preview');
    }

    public function postDefinitionEstateRoom()
    {
//     return \Input::all();
        $validator = \Validator::make(\Input::all(), [
            'guest' => 'required|min:1|integer',
            'price' => 'required|min:1|numeric',
            'shortStay' => 'integer',
            'shortPrice' => 'numeric',
            'miniRent' => 'integer',
            'prefCheckin' => 'integer',
            'prefCheckout' => 'integer',
            'rentalSub' => 'integer',
            'bookingFlex' => 'integer',
            'glazing' => 'required',
            'windows' => 'required|min:0|integer',
            'disposition' => 'required',

        ]);
        if ($validator->fails()) {
            return \Redirect::to('definition_estate_shared?number=' . \Input::get('number'))->withErrors($validator);
        }

        $estate = New Estate();

        $estate->guest_nb = \Input::get('guest');
        $estate->shared = \Input::get('radioShared') == null ? '0' : \Input::get('radioShared');
        $estate->rent = \Input::get('price');
        $estate->mini_stay = \Input::get('miniRent');
        $estate->booking_flexibility = \Input::get('bookingFlex');
        $estate->checkin_preference = \Input::get('prefCheckin');
        $estate->checkout_preference = \Input::get('prefCheckout');
        $estate->rental_sub = \Input::get('rentalSub');
        $estate->windows = \Input::get('windows');
        $estate->double_glazing = \Input::get('glazing');
        $estate->street_side = \Input::get('disposition');


        $range_period = array();
        for ($i = 0; $i < count(\Input::get('priceRange')); $i++) {
            $range_period[$i]['from'] = \Input::get('from.' . $i);
            $range_period[$i]['to'] = \Input::get('to.' . $i);
            $range_period[$i]['price'] = \Input::get('priceRange.' . $i);
        }

        $estate->range_period = serialize($range_period);

        $room = Room::find(\Input::get('id_room'));

        $room->estates()->save($estate);

        $privateBathroom = Room::find(\Input::get('bathroomId'));

        $estate->privateRooms()->save($privateBathroom);

        foreach (\Input::get('priceFee') as $key => $fee) {
            if ($fee > 0) {
                $newFee = Fee::find($key);

                if (\Input::get('slide.' . $key) == "1") {
                    $monthly = 1;
                } else {
                    $monthly = 0;
                }
                $estate->fees()->save($newFee, ['price' => $fee, 'monthly' => $monthly]);
            }
        }

        foreach (\Input::get('restriction') as $restriction) {
            $newRestriction = Restriction::find($restriction);

            $estate->restrictions()->save($newRestriction);
        }

        $next = \Input::get('number') + 1;
        return \Redirect::to('definition_estate_shared?number=' . $next);

    }

    public function updateEstateRoom()
    {
//        return \Input::all();
        $validator = \Validator::make(\Input::all(), [
            'guest' => 'required|min:1|integer',
            'price' => 'required|min:1|numeric',
            'shortStay' => 'integer',
            'shortPrice' => 'numeric',
            'miniRent' => 'integer',
            'prefCheckin' => 'integer',
            'prefCheckout' => 'integer',
            'rentalSub' => 'integer',
            'bookingFlex' => 'integer',
            'glazing' => 'required',
            'windows' => 'required|min:0|integer',
            'disposition' => 'required',

        ]);
        if ($validator->fails()) {
            return \Redirect::to('definition_estate_shared?number=')->withErrors($validator);
        }

        $estate = Estate::find(\Input::get('idEstate'));

        $estate->guest_nb = \Input::get('guest');
        $estate->shared = \Input::get('radioShared') == null ? '0' : \Input::get('radioShared');
        $estate->rent = \Input::get('price');
        $estate->mini_stay = \Input::get('miniRent');
        $estate->booking_flexibility = \Input::get('bookingFlex');
        $estate->checkin_preference = \Input::get('prefCheckin');
        $estate->checkout_preference = \Input::get('prefCheckout');
        $estate->rental_sub = \Input::get('rentalSub');
        $estate->windows = \Input::get('windows');
        $estate->double_glazing = \Input::get('glazing');
        $estate->street_side = \Input::get('disposition');


        $range_period = array();
        for ($i = 0; $i < count(\Input::get('priceRange')); $i++) {
            $range_period[$i]['from'] = \Input::get('from.' . $i);
            $range_period[$i]['to'] = \Input::get('to.' . $i);
            $range_period[$i]['price'] = \Input::get('priceRange.' . $i);
        }

        $estate->restrictions()->detach();
        if (\Input::get('restriction') != null) {
            foreach (\Input::get('restriction') as $restriction) {
                $newRestriction = Restriction::find($restriction);


                $estate->restrictions()->save($newRestriction);

            }
        }
        $estate->range_period = serialize($range_period);

        $estate->privateRooms()->detach();

        if (\Input::get('privateBathroom') == 1) {
            $privateBathroom = Room::find(\Input::get('bathroomSize'));

            $estate->privateRooms()->save($privateBathroom);

        }

        if (\Input::get('privateKitchen') == 1) {
            $privateKitchen = Room::find(\Input::get('kitchenSize'));

            $estate->privateRooms()->save($privateKitchen);
        }

        if (\Input::get('privateToilet') == 1) {
            $privateToilet = Room::find(\Input::get('toiletSize'));

            $estate->privateRooms()->save($privateToilet);
        }

        $estate->save();
//        return \Input::all();
        foreach (\Input::get('priceFee') as $key => $fee) {
            if ($fee > 0) {
                $newFee = Fee::find($key);

                if (\Input::get('slide.' . $key) == "1") {
                    $monthly = 0;
                } else {
                    $monthly = 1;
                }

                if ($estate->fees()->where('Estate_fee.idFee', $key)->first() != null) {
                    $estate->fees()->updateExistingPivot($key, ['price' => $fee, 'monthly' => $monthly]);
                } else {
                    $estate->fees()->save($newFee, ['price' => $fee, 'monthly' => $monthly]);
                }
            }
        }

        return \Redirect::to('final_preview');
    }

    /* AJAX */
    public function getArea()
    {
        $idCity = \Input::get('idCity');
        $idProperty = \Input::get('idProperty');
        $areaDefault = 0;

        if ($idProperty != 0) {
            $property = Property::find($idProperty);
            $areaDefault = $property->area()->first()->idArea;
        }

        $area = Area::where('idCity', '=', $idCity)->get();

        $content = "";

        foreach ($area as $singleArea) {
            $content .= '<option value="' . $singleArea->idArea . '"';
            $content .= $singleArea->idArea == $areaDefault ? 'selected' : '';
            $content .= '>' . $singleArea->label . '</option>';
        }

        return $content;
    }

    public function getTranslation()
    {
        $index = \Input::get('index');
        $tranlation = trans('landlord.' . $index);
        return json_encode($tranlation);
    }

    public function getRoom()
    {
        $id = \Input::get('idRoom');
        $room = Room::find($id);

        $divGroup = "<div class='form-inline'>";
        $finDivGroup = "</div>";

        $content = $divGroup;
        $content .= \Form::open(['url' => 'update_room', 'id' => 'formUpdateRoom']);
        $content .= \Form::hidden('idRoom', $room->idRoom);
        $content .= \Form::label('size', 'Size : ', ['class' => 'col-md-3']);
        $content .= \Form::number('size', $room->size, ['class' => 'form-control']);
        $content .= $finDivGroup;


        return $content;
    }

    public function updateProperty()
    {
        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);

        $validator = \Validator::make($formFields, [
            'address' => 'required',
            'city' => 'required|string',
            'country' => 'required|string',
            'size' => 'required|numeric',
            'zip' => 'required'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $property = Property::find($formFields['idProperty']);
            $address = $property->address()->first();

            $address->street = $formFields['address'];
            $address->city = $formFields['city'];
            $address->country = $formFields['country'];
            $property->size = $formFields['size'];
            $address->zip = $formFields['zip'];

            $address->save();
            $property->save();

        }

    }

    public function deleteEstate()
    {


        $validator = \Validator::make(\Input::all(), [
            'idRoom' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $room = Room::find(\Input::get('idRoom'));
            $estate = $room->estates()->first();

            $estate->status = 1;
            $estate->save();

        }
    }

    public function activateEstate()
    {
        $validator = \Validator::make(\Input::all(), [
            'idRoom' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $room = Room::find(\Input::get('idRoom'));
            $estate = $room->estates()->first();

            $estate->status = 2;
            $estate->save();

        }
    }

    public function updateRoom()
    {
        $inputData = \Input::get('data');
        parse_str($inputData, $formFields);
        $validator = \Validator::make($formFields, [
            'idRoom' => 'required|integer',
            'size' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $room = Room::find($formFields['idRoom']);
            $room->size = $formFields['size'];
            $room->save();
        }
    }

    public function deleteRoom()
    {
        $validator = \Validator::make(\Input::all(), [
            'idRoom' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $room = Room::find(\Input::get('idRoom'));
            $room->delete();

        }
    }
}
