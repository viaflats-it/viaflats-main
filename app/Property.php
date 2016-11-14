<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';

    protected $primaryKey = 'idProperty';

    protected $fillable = [

    ];

    public function estates()
    {
        return $this->morphMany('App\Estate', 'estateMorph', 'type_element', 'idElement');
    }

    public function address()
    {
        return $this->belongsTo('App\Address', 'idAddress');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'idArea');
    }
}
