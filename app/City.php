<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'idCity';
    public $timestamps = false;

    public function city()
    {
        return $this->find(all);
    }

}
