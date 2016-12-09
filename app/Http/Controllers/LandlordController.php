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
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Landlord;
use App\User;
use Illuminate\support;
use Illuminate\Support\Facades\Input;
use Image;
use App\City;
use App\Area;
use App\Type_room;
use App\Tenant;
use App\ParentTenant;


class LandlordController extends Controller
{
    public function showDetailsProperty()
    {
        $City = City::pluck('libelle', 'idCity')->all();

        return view('landlord/add_property/details_property', compact('City'));
    }

    public function showDefinitionProperty()
    {

        $piecesList = Type_room::pluck('label', 'idTypeRoom')->map(function ($pieces) {
            return trans(sprintf('landlord.%s', $pieces));
        })->toArray();

        $pieces = Type_room::all();

        $fields = ['number', 'size', 'furnished'];
        return view('landlord/add_property/def_prop', compact('piecesList', 'pieces', 'fields', 'ID'));
    }

    public function showDefinitionArea()
    {
        $numb = \Input::get('number');
        $property = Property::find(24);


        if ($property->shared == 1) {
            $rooms = $property->rooms->where('idTypeRoom', '!=', 3);
            $key = 0;
            foreach ($rooms as $room) {
                if ($room != null) {
                    $roomArray[$key] = $room;
                    $key++;
                }
            }

        } else {
            $roomArray = $property->rooms;
        }


        if (isset($roomArray[$numb])) {
            $room = $roomArray[$numb];
        } else {
            return \Redirect::to('definition_estate');
        }


        $typeRoom = $room->type_room()->first();
        $amenities = $typeRoom->amenities()->get();

        return view('landlord/add_property/def_area', compact('room', 'typeRoom', 'amenities', 'numb'));
    }

    public function showDefinitionEstate()
    {
        $property = Property::find(24);
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
        foreach ($rooms as $room) {
            $roomsLabel[$room->idRoom] = $room->type_room()->first();
            $roomsAmenities[$room->idRoom] = $room->amenities()->get();
        }

        return view('landlord/add_property/def_estate', compact('fees', 'roomsAmenities', 'area', 'property', 'rooms', 'restrictions', 'type', 'roomsLabel', 'address'));

        return view('landlord/add_property/def_estate_shared', compact('fees', 'roomsAmenities', 'area', 'property', 'room', 'restrictions', 'type', 'roomsLabel', 'address'));

    }

    public function showDefinitionEstateShared()
    {
        $property = Property::find(24);


        $numb = \Input::get('number');
        $typeRoom = \DB::table('type_room')->get();

        foreach ($typeRoom as $value) {
            if ($value->label == 'bedroom')
                $idBedroom = $value->idTypeRoom;

            if ($value->label == 'bathroom')
                $idBathRoom = $value->idTypeRoom;
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


        $bathroom = $property->rooms()->where('idTypeRoom', '=', $idBathRoom)->pluck('size', 'idRoom');

        foreach ($rooms as $value) {
            $roomsLabel[$value->idRoom] = $value->type_room()->first();
            $roomsAmenities[$value->idRoom] = $value->amenities()->get();
        }

        return view('landlord/add_property/def_estate_shared', compact('bathroom', 'numb', 'roomsLabel', 'rooms', 'fees', 'roomsAmenities', 'area', 'property', 'room', 'restrictions', 'type', 'address'));


    }

    public function showUpdateEstateRoom()
    {
        $property = Property::find(24);

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
        $property = Property::find(24);

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
        $property = Property::find(24);
        $city = City::find($property->area()->first()->idCity);
        $photographers = $city->photographers()->get();

        foreach ($photographers as $photographer) {
            $blop = unserialize($photographer->availabilities);


            if (is_array($blop) || is_object($blop))
            {
                foreach ($blop as $key => $value)
                {
                   $date[$key] = $value['date'];
                }
            }


        }
        return view('landlord/add_property/appointment', compact('city', 'property', 'date'));
    }

    function showProperties()
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

            $path = public_path('profilepics/' . $filename);

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


    /* MANAGE ADD PROPERTY */

    public function postDetailsProperty()
    {
        $validator = \Validator::make(\Input::all(), [
            'type' => 'required',
            'room_type' => 'required',
            'Tsize' => 'required',
            'streetNumber' => 'required|integer',
            'street' => 'required',
            'zip' => 'required|alpha_num',
            'city' => 'required',
            'area' => 'required',
            'country' => 'required'
            // 'wsarrond' => 'required',
        ]);

        if ($validator->fails()) {
            return \Redirect::to('add_property')->withErrors($validator)->withinput();
        }

        $property = new Property();

        $property->idLandlord = \Auth::user()->idPerson;
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

        \Session::put('ID', $property->idProperty);

        return \Redirect::to('definition_property');
    }

    public function postDefinitionProperty()
    {
//        return \Input::all();
        $property = Property::find(24);
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
            'dateIn' => 'required',
            'bookingFlex' => 'integer'
        ]);

        if ($validator->fails()) {
            return \Redirect::to('definition_estate')->withErrors($validator)->withinput();
        }

        $estate = New Estate();
        $estate->guest_nb = \Input::get('guest');
        $estate->rent = \Input::get('price');
        $estate->mini_stay = \Input::get('miniRent');
        $estate->booking_flexibility = \Input::get('bookingFlex');
        $estate->checkin_preference = \Input::get('prefCheckin');
        $estate->checkout_preference = \Input::get('prefCheckout');
        $estate->rental_sub = \Input::get('rentalSub') ? \Input::get('rentaSub') : 0;
        $estate->furnished = \Input::get('furnished');

        $property = Property::find(24);

        $range_period = array();
        for ($i = 0; $i < count(\Input::get('priceRange')); $i++) {
            $range_period[$i]['from'] = \Input::get('from.' . $i);
            $range_period[$i]['to'] = \Input::get('to.' . $i);
            $range_period[$i]['price'] = \Input::get('priceRange.' . $i);
        }

        $estate->range_period = serialize($range_period);


        $property->estates()->save($estate);

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
        $Area = Area::where('idCity', '=', $idCity)->pluck('label', 'idArea');
        return json_encode($Area->all());
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
