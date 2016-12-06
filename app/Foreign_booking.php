<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foreign_booking extends Model
{
    protected $table = 'foreign_booking';

    protected $primaryKey = 'idForeignBooking';

    protected $fillable =[
        'first_name','age','student','gender','checkin','checkout','real_checkout','idEstate'
    ];

    public $timestamps = false;

}
