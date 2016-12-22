<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    protected $primaryKey = 'idTag';

    protected $fillable = [
        'idTag','label',
    ];

    public function tenant()
    {
        return $this->belongsToMany('App\Tenant', 'Tenant_tag', 'idTag', 'idTenant');
    }

    public $timestamps = false;
}
