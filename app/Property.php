<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';

    protected $primaryKey = 'idProperty';
    protected $fillable = [
        'idLandlord', 'type', 'shared', 'idArea', 'size', 'creation_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public function rooms()
    {
        return $this->hasMany('App\Room', 'idProperty');
    }


    public function address()
    {
        return $this->belongsTo('App\Address', 'idAddress');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'idArea');
    }


    public function estates()
    {
        return $this->morphMany('App\Estate', 'estateMorph', 'type_element', 'idElement');
    }

    public $timestamps = false;
}
