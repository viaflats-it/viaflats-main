<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $primaryKey = 'idBooking';

    public function estate()
    {
        return $this->belongsTo('App\Estate', 'idEstate');
    }
}
