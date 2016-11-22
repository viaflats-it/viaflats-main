<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property_restriction extends Model
{
    //
    protected $table= 'property_restriction';

    protected $fillable = [
        'idProperty', 'idRestriction',
    ];

    public function property()
    {
        return $this->belongsTo('App\property', 'idProperty');
    }
}
