<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';

    protected $primaryKey = 'idRoom';

    protected $fillable = [

    ];

    public function estates()
    {
        return $this->morphMany('App\Estate', 'estateMorph' , 'type_element' , 'idElement');
    }

    public function property()
    {
        return $this->belongsTo('App\Property', 'idProperty');
    }
}
