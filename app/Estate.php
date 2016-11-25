<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $table = 'estate';

    protected $primaryKey = 'idEstate';
    protected $fillable = [
        'idElement' , 'type_element' ,'guest_nb' ,'rent' ,'short_rent' ,'short_period' ,'booking_flexibility'
        ,'checkin_preference' ,'checkout_preference' , 'final_checkin' ,'status' ,'viaflats_percentage' ,
        'last_update' , 'views_nb' ,'idElement' ,'positive_rate' ,'negative_rate' ,'creation_date' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public function estateMorph()
    {
        return $this->morphTo('estateMorph', 'type_element' , 'idElement');
    }

    public function fees()
    {
        return $this->belongsToMany('App\Fee', 'estate_fee', 'idEstate' , 'idFee')->withPivot('price' , 'monthly');
    }

    public function restrictions()
    {
        return $this->belongsToMany('App\Restriction', 'estate_restriction', 'idEstate' , 'idRestriction');
    }

    public function privateRooms()
    {
        return $this->belongsToMany('App\Room', 'estate_private', 'idEstate' , 'idRoom');
    }

}
