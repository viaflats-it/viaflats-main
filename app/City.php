<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';

    protected $primaryKey = 'idCity';
    protected $fillable = [
        'libelle'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public $timestamps = false;
}
