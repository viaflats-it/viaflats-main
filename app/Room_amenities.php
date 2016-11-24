<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room_amenities extends Model
{
    //
    protected $table= 'room_amenities';

    protected $fillable = [
        'idRoom', 'idAmenity', 'number'
    ];

    public $timestamps = false;

}
