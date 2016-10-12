<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Landlord extends Model
{
    protected $table= 'landlord';

    protected $primaryKey = 'idPerson';

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

    public function person()
    {
        return $this->hasOne('App\User', 'idPerson');
    }
}
