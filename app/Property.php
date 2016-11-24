<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
    protected $table= 'property';

    protected $primaryKey = 'idProperty';

    protected $fillable = [
        'idProperty', 'idLandlord', 'type', 'shared', 'idArea', 'size'
    ];

    protected $dates = ['creation_date'];

    public $timestamps = false;

    public function area()
    {
        return $this->belongsTo('App\Area', 'idArea');
    }

    public function landlord()
    {
        return $this->belongsTo('App\Landlord', 'idLandlord');
    }

    public function property_restrictions()
    {
        return $this->hasMany('App\Property_restriction', 'idProperty');
    }

    public function estates()
    {
        return $this->morphMany('App\Estate', 'estateMorph', 'type_element', 'idElement');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room','idProperty');
    }


    public function address()
    {
        return $this->belongsTo('App\Address', 'idAddress');
    }
}
