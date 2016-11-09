<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_way extends Model
{
    protected $table = 'payment_way';

    protected $primaryKey = 'idPayment';

    public function payment_way()
    {
        return $this->belongsToMany('App\Landlord','Payment_way_landlord','idPayment','idLandlord');
    }
}
