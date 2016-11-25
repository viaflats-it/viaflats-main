<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_room extends Model
{
    protected $table = 'type_room';

    protected $primaryKey = 'idTypeRoom';
    protected $fillable = [
       'label'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function rooms()
    {
        return $this->hasMany('App\Room','idTypeRoom');
    }


    public function amenities()
    {
        return $this->belongsToMany('App\Amenities','amenities_type_room', 'idTypeRoom', 'idAmenity');
    }

    public $timestamps = false;
}
