<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    protected $table = 'amenities';

    protected $primaryKey = 'idAmenity';
    protected $fillable = [
        'label'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public function type_room()
    {
        return $this->belongsToMany('App\Type_room','amenities_type_room', 'idAmenity' , 'idTypeRoom');
    }

    public function room()
    {
        return $this->belongsToMany('App\Room','amenities_room', 'idAmenity' , 'idRoom');
    }


    public $timestamps = false;
}
