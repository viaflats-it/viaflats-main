<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address_list extends Model
{
    protected $table = 'address_list';

    protected $fillable = [
        'idAddress', 'idEntity', 'entity_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public $timestamps = false;
}
