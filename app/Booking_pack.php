<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_pack extends Model
{
    protected $table = 'booking_pack';

    protected $primaryKey = 'idBookingPack';

    protected $fillable = [

    ];

    public $timestamps = false;

    public function bookings()
    {
        return $this->hasMany('App\Booking','idBookingPack');
    }
}
