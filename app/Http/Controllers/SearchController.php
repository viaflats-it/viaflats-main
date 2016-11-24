<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\Address;
use App\Property;
use App\Area;
use App\Estate;
use App\Http\Requests;

class SearchController extends Controller
{
    public function showMap()
    {

    }

    public function showProperties()
    {

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
