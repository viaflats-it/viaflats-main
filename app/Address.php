<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'Address';

    protected $primaryKey = 'idAddress';

    protected $fillable = [
        'street_number', 'street', 'complement', 'zip', 'city', 'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function tenant()
    {
        return $this->hasOne('App\Tenant', 'idAddress');
    }

    public function Parent()
    {
        return $this->hasOne('App\Parents', 'idAddress');
    }

    public $timestamps = false;
}
