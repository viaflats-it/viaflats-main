<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';

    protected $primaryKey = 'idRoom';
    protected $fillable = [
        'idProperty', 'idTypeRoom', 'size', 'furnished'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public $timestamps = false;

    public function property()
    {
        return $this->belongsTo('App\Property', 'idProperty');
    }

    public function type_room()
    {
        return $this->belongsTo('App\Type_room', 'idTypeRoom');
    }

    public function amenities()
    {
        return $this->belongsToMany('App\Amenities','amenities_room', 'idRoom', 'idAmenity');
    }

    public function estates()
    {
        return $this->morphMany('App\Estate', 'estateMorph' , 'type_element' , 'idElement');
    }

    public function media_room()
    {
        return $this->hasMany('App\Media_room', 'idRoom');
    }

}
