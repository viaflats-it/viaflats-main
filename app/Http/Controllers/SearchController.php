<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\Address;
use App\Property;
use App\Area;
use App\Estate;
use App\City;
use App\Room;
use App\Media;
use App\Booking;
use App\Http\Requests;



class SearchController extends Controller
{
    public function showMap()
    {

    }

    public function showProperties()
    {

    }

    public function test()
    {
        return view('test');
    }

    public function search()
    {

        //$e = Estate::where("idEstate", 1)->first();
        //$e->booking_date=serialize(["12/09/2009", "17/09/2009", "30/09/2009"]);
        //$e->save();

        $city = \Input::get("city");
        $start = \Input::get("start");
        $end = \Input::get("end");
        $order = [
            ['name' => "price", 'orderBy' => "desc", 'active' => false],
            ['name' => "size", 'orderBy' => "asc", 'active' => false],
            ['name' => "ranking", 'orderBy' => "asc", 'active' => false],
            ['name' => "index", 'orderBy' => "asc", 'active' => true]];

        $graph = SearchController::initGraph();
        $list = SearchController::initList($city, $start, $end);
        SearchController::sortList($list, $graph);
        return $list;
        //return view('search', compact('city', 'start', 'end'));
    }

    public function initGraph()
    {
        return [[2, 10], [3, 9], [4, 8], [5, 7], [6, 6], [7, 5], [8, 4], [9, 3], [10, 2], [0, 1]];
    }

    public function initList($city, $start, $end)
    {
        $list=[];
        try
        {
            $IDcity = City::where("libelle", $city)->first()->idCity;
        }
        catch(Exception $e)
        {
            header('Location: index');
            exit();
        }

        $rooms = Room::all();
        $estates = Estate::where("type_element", "App\Room");
        $index=0;

        foreach($rooms as $room)
        {

            $landlord=$room->property->landlord;
            $restrictions = $room->property->property_restrictions;
            echo $room->property->area->city->idCity;
            if($room->property->area->city->idCity==$IDcity && $estate=$estates->where("idElement", $room->idRoom)->first())
            {
                $medias_room = $room->media_room;
                $quality=0;
                $bookings_count = count(Booking::where('idEstate', $estate->idEstate)->get());
                $bookings_accepted = count(Booking::where('idEstate', $estate->idEstate)->where('status', 3)->get());
                $acceptance_rate = (1/$bookings_count)*$bookings_accepted;
                $dates = unserialize($estate->booking_date);
                $free=true;
                foreach($medias_room as $media_room)
                {
                    if($media_room->media->type=='picture')
                    {
                        $quality=$quality+1;
                    }

                    if($media_room->media->type=='video')
                    {
                        $quality=$quality+10;
                    }
                }

                if($dates!=null)
                {
                    foreach($dates as $date)
                    {
                        if(strtotime($date)<=strtotime($end) && strtotime($date)>=strtotime($start))
                        {
                            $free=false;
                            break;
                        }
                    }
                    $list[$index]=['index' => $index, 'id' => $room->idRoom, 'size' => $room->size, 'price' => $estate->estate_fee->price, 'nearestDate' => $start, 'last_update' => $estate->last_update, 'acceptanceRate' => $acceptance_rate, 'quality' =>$quality, 'neighborhood' => $room->property->whats_around, 'features' => $room->amenities, 'landlord_responseTime' => $room->property->landlord->response_time, 'new_landlord' => substr($landlord->creation_date, 0, 10), 'tenants_number' => $bookings_accepted, 'landlord_conditions' => $restrictions];
                    $index=$index+1;
                }
            }
        }
        return $list;
    }

    public function sortList($list, $graph)
    {
        foreach ($list as $listItem) {
            $index = 0;

            foreach ($graph as $key) {
                switch ($key) {

                    case 0: // nearest date moving (both works < >)
                        // 100 - Math.abs(Math.round(((roomAvailableDate - start) / (end - start)) * 100)) * 10/100 ( !! ! ! !! if roomAvailableDate > end negative value )
                        break;
                    case 1: // last updated
                        // lastupdate > today (both works)
                        // lastupdate < today
                        // 100 - Math.abs(Math.round(((pastDay - start) / (start+10 - start)) * 100)) * 9/100 ( !!! IF pastDay > start+10 negative value)
                        break;
                    case 2: // acceptance rate
                        // Math.abs((% * 8)/ 100)
                        break;
                    case 3: // Price
                        // Math.abs(7 - Maths.round()( 7 * (price logic %) / 100 ))) (!! logic price > ou < -/+ 100% )
                        break;
                    case 4: // Quality
                        // Math.abs(6 - Maths.round()( 6 * (quality logic %) / 100 ))) (!! logic price > ou < -/+ 100% )
                        break;
                    case 5: //neighborhood
                        // if class == 5 or poor = 0 ...
                        break;
                    case 6: // featuresl
                        // list feature mark  =/+/- 4
                        break;
                    case 7: // responsible landlords
                        // Math.abs((% * 3)/ 100)
                        break;
                    case 8: // new landlord
                        // 100 - Math.abs(Math.round(((dateSuscribe - start) / (end - start)) * 100)) * 10/100 ( !! ! ! !! if dateSuscribe > end negative value )
                        break;
                    case 9: // Tenants number + Landords Conditions
                        // ((3 * nbTenants) / 0.5) * 100 + ( (1 * nbLandlorsConditions) / 0.5) * 100
                        break;
                    default:
                        $listItem['index'] = $index;
                        break;
                }
            }
        }
    }

    public function includeValue($value, $array)
    {
        foreach ($array as $arrayItem) {
            if ($value == $arrayItem) {
                return true;
            }
        }
        return false;
    }

    public function removeValue($value, $array, $param)
    {
        foreach ($array as $arrayIndex) {
            if ($value == $array[$arrayIndex][$param]) {
                unset($array[$arrayIndex][$param]);
            }
        }
        return $array;
    }

    public function orderList($list)
    {
        $list = $list . uasort($list, 'SearchController::sortByValue');
    }

    public function sortByValue($a, $b)
    {
        if ($a > $b) {
            return 1;
        }
        if ($a < $b) {
            return -1;
        }
        return 0;
    }

    public function removeTAB($values, $array, $param)
    {
        foreach ($array as $arrayIndex) {
            foreach ($values as $value) {
                if ($value == $array[$arrayIndex][$param]) {
                    unset($array[$arrayIndex][$param]);
                }
            }
        }
        return $array;
    }

    function applyCriteria($criterias)
    {
        foreach ($criterias as $criteria) {
            // criteria type : number / string if number < >  == if string check if tab then < > ==
            if ($criteria['type'] == 'number') {

            } else {

            }
        }
    }

    function orderSearh($orderByUser)
    {
        foreach ($order as $value) {
            if ($orderByUser[0] == $value['name']) {
                $value['orderBy'] = $orderByUser[1];
                foreach ($order as $value) {
                    $value['active'] = false;
                }
                $value['active'] = true;
            }
        }
    }

    public function FirstStepProperties()
    {
        $tenant = Tenant::where("idPerson", "=", \Auth::user()->idPerson)->first();
        $estate = Estate::all();
        $day = array(strtotime($tenant->expected_in));
        $numDay = abs(strtotime($tenant->expected_in) - strtotime($tenant->expected_out)) / 60 / 60 / 24;
        for ($i = 1; $i < $numDay; $i++) {
            array_push($day, strtotime("+{$i} day", strtotime($tenant->expected_in)));
        }
        array_push($day, strtotime($tenant->expected_out));
        $area = array();
        $sugg = array();
        $available_list = array();
        //First Selection with City and type of room choices
        foreach ($estate as $e) {
            $booked_before = array();
            $booking_date = unserialize($e->booking_date);
            $available = true;
            foreach ($booking_date as $date) {
                foreach ($day as $d) {
                    if ($date == $d) {
                        $available = false;
                        break;
                    }
                }
                if ($date < strtotime($tenant->expected_in)) {
                    array_push($booked_before, $date);
                }
            }

            if ($available == true) {
                $type = $e->estateMorph()->first();

                //Available From
                foreach ($booked_before as $booked) {
                    foreach ($booked_before as $b) {
                        if ($booked > $b) {
                            $available_date = $booked;
                        }
                    }
                }

                array_push($available_list, date('d - m - Y', $available_date));
                if ($tenant->expected_type == 1) { //Entire Place
                    if ($e->type_element == 'App\Property') {
                        $address = $type->address()->first();
                        if ($address->city == $tenant->expected_city()->first()->libelle) {
                            if ($tenant->budget_min <= $e->rent && $tenant->budget_max >= $e->rent) {
                                array_push($sugg, $e);
                                array_push($area, $type->area()->first());
                            }
                        }
                    }
                } elseif ($tenant->expected_type == 0) { //No pref
                    if ($e->type_element == 'App\Room') {
                        $prop = $type->property()->first();
                        $address = $prop->address()->first();
                        array_push($area, $prop->area()->first());
                    } else {
                        $address = $type->address()->first();
                        array_push($area, $type->area()->first());
                    }
                    //City
                    if ($address->city == $tenant->expected_city()->first()->libelle) {
                        if ($tenant->budget_min <= $e->rent && $tenant->budget_max >= $e->rent) {
                            array_push($sugg, $e);
                        }
                    }
                } else {
                    if ($e->type_element == 'App\Room') { //Room Shared/Private
                        $prop = $type->property()->first();
                        $address = $prop->address()->first();
                        if ($address->city == $tenant->expected_city()->first()->libelle) {
                            if ($tenant->budget_min <= $e->rent && $tenant->budget_max >= $e->rent) {
                                array_push($sugg, $e);
                                array_push($area, $prop->area()->first());
                            }
                        }
                    }
                }
            }
        }
        return \Response::json(array('Property' => $sugg,
            'day' => serialize($day),
            'City' => $tenant->expected_city()->first()->libelle,
            'Area' => $area,
            'Available' => $available_list,
        ));
    }

}
