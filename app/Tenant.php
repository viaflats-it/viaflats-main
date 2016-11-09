<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenant';

    protected $primaryKey = 'idTenant';

    protected $fillable = [
        'idTenant', 'student', 'account_state', 'about', 'spoken_languages', 'nationality', 'idPerson', 'expected_city', 'budget_min',
        'budget_max', 'expected_in', 'expected_out', 'expected_type', 'gender', 'birth_place', 'birth_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function address()
    {
        return $this->belongsTo('App\Address', 'idAddress');
    }

    public function parent()
    {
        return $this->hasOne('App\Parents', 'idTenant');
    }

    public function person()
    {
        return $this->belongsTo('App\User', 'idPerson');
    }

    public function expected_city()
    {
        return $this->belongsTo('App\City','expected_city');
    }

    protected $dates = ['creation_date'];

    public $timestamps = false;

}
