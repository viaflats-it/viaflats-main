<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $primaryKey = 'idAddress';
    protected $fillable = [
        'street_number', 'street', 'complement', 'zip', 'city', 'country'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public $timestamps = false;


    public function property()
    {
        return $this->hasOne('App\Property','idAddress', 'idAddress');
    }

    public function tenant()
    {
        return $this->hasOne('App\Tenant', 'idAddress');
    }
    public function Parent()
    {
        return $this->hasOne('App\Parent', 'idAddress');
    }
}
