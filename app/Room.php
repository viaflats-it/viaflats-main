<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $table= 'room';

    protected $primaryKey = 'idRoom';

    protected $fillable = [
        'idRoom', 'idProperty', 'idTypeRoom', 'size', 'furnished'
    ];

    public $timestamps = false;


    public function property()
    {
        return $this->belongsTo('App\Property', 'idProperty');
    }

    public function amenities()
    {
        return $this->hasMany('App\Room_amenities', 'idRoom');
    }

    public function media_room()
    {
        return $this->hasMany('App\Media_room', 'idRoom');
    }
}
