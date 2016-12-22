<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'restriction';

    protected $primaryKey = 'idRestriction';
    protected $fillable = [
        'label'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public $timestamps = false;

    public function estates()
    {
        return $this->belongsToMany('App\Estate', 'estate_restriction', 'idRestriction' , 'idEstate');
    }

}
