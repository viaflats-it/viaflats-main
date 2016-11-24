<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $primaryKey = 'idBooking';

    public $timestamps = false;

    public function estate()
    {
        return $this->belongsTo('App\Estate', 'idEstate');
    }

    public function tenant(){
        return $this->belongsTo('App\Tenant','idTenant');
    }

}
