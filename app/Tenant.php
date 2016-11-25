<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table= 'tenant';

    protected $primaryKey = 'idTenant';

    protected $fillable = [
        'idTenant', 'student', 'account_state', 'about', 'spoken_languages', 'nationality', 'idPerson'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public  $timestamps = false;

//    protected $dates = ['creation_date'];


    public function address()
    {
        return $this->belongsTo('App\Address', 'idAddress');
    }
    public function parent()
    {
        return $this->hasOne('App\Parent', 'idTenant');
    }
    public function person()
    {
        return $this->belongsTo('App\Person', 'idPerson');
    }

}
