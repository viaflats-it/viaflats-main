<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    //
    protected $table= 'estate';

    protected $primaryKey = 'idEstate';

    protected $fillable = [
        'idEstate', 'idElement', 'type_element', 'guest_nb', 'rent', 'short_rent', 'short_period', 'booking_flexibility', 'estatecol', 'checking_preference', 'checkout_preference', 'final_checking', 'status', 'viaflats_percentage', 'last_update', 'views_nb', 'positive_rate', 'negative_rate', 'booking_date', 'creation_date'
    ];

    public $timestamps = false;


    public function estate_fee()
    {
        return $this->hasOne('App\Estate_fee', 'idEstate');
    }
}
