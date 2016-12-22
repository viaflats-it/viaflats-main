<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = 'fee';

    protected $primaryKey = 'idFee';
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
        return $this->belongsToMany('App\Estate', 'estate_fee', 'idFee' , 'idEstate')->withPivot('price' , 'monthly');
    }

}
