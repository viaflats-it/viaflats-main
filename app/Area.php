<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    protected $primaryKey = 'idArea';

    public function Property()
    {
        return $this->hasOne('App\Property', 'idArea');
    }
}
