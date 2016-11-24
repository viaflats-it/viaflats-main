<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $table = 'estate';

    protected $primaryKey = 'idEstate';

    protected $fillable = [
        'idElement', 'type_element', 'shared',
    ];

    public function estateMorph()
    {
        return $this->morphTo('estateMorph', 'type_element', 'idElement');
    }

    public function booking()
    {
        return $this->hasMany('App\Booking', 'idEstate');
    }

}
