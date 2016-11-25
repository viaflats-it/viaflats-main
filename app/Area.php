<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    protected $primaryKey = 'idArea';
    protected $fillable = [
        'label','idCity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public $timestamps = false;

    public function properties(){
        return $this->hasMany('App\Property','idArea');
    }
}
