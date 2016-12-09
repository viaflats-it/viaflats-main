<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photographer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'photographer';

    protected $primaryKey = 'idPhotographer';
    protected $fillable = [
        'idPhotographer', 'idCity' , 'availabilities', 'creation_date', 'idPerson'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public $timestamps = false;



    public function person()
    {
        return $this->belongsTo('App\User' , 'idPerson');
    }

    public function City()
    {
        return $this->belongsTo('App\City', 'idCity');
    }

}
