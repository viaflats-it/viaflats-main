<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Landlord extends Model
{
    protected $table = 'landlord';

    protected $primaryKey = 'idLandlord';

    protected $fillable = [
        'idLandlord', 'corporate', 'account_state', 'about', 'verified', 'idPerson'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = ['creation_date'];

    public $timestamps = false;


    public function person()
    {
        return $this->hasOne('App\User', 'idPerson');
    }

    public function payment_way()
    {
        return $this->belongsToMany('App\Payment_way', 'Payment_way_landlord', 'idLandlord', 'idPayment');
    }

    public function property()
    {
        return $this->hasMany('App\Property','idLandlord');
    }

}
