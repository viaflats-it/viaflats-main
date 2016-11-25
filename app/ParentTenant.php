<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentTenant extends Model
{


    protected $table = 'parent';

    protected $primaryKey = 'idParent';
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone_indicator', 'phone', 'idTenant'
    ];

    public $timestamps = false;


    public function address()
    {
        return $this->belongTo('App\Address', 'idAddress');
    }

    public function tenant()
    {
        return $this->belongTo('App\Tenant', 'idTenant');
    }
}
