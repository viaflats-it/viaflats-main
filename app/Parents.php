<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parent';

    protected $primaryKey = 'idParent';

    protected $fillable = [
        'idTenant', 'first_name', 'last_name', 'email', 'phone', 'idAddress',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function address()
    {
        return $this->belongTo('App\Address', 'idAddress');
    }

    public function tenant()
    {
        return $this->belongTo('App\Tenant', 'idTenant');
    }

    public $timestamps = false;
}
