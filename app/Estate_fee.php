<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estate_fee extends Model
{
    //
    protected $table= 'estate_fee';

    protected $fillable = [
        'idEstate', 'idFee', 'price', 'monthly'
    ];

    public $timestamps = false;
}
