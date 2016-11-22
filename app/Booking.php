<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table= 'booking';

    protected $primaryKey = 'idBooking';

    protected $fillable = [
        'idBooking', 'idTenant', 'checkin', 'checkout', 'real_checkout', 'status', 'creation date', 'idBookingPack', 'booking_fee', 'idEstate', 'rejection_cause', 'rejection_cause_comment', 'payment_way', 'payment_date', 'idCode'
    ];

}
