<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table= 'area';

    protected $primaryKey = 'idArea';

    protected $fillable = [
        'idArea', 'idCity', 'label'
    ];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\City', 'idCity');
    }

    public function Property()
    {
        return $this->hasOne('App\Property', 'idArea');
    }

    public function properties(){
        return $this->hasMany('App\Property','idArea');
    }
}
