<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media_room extends Model
{
    //
    protected $table= 'Media_room';

    protected $fillable = [
        'idMedia','idRoom',
    ];

    public $timestamps = false;


    public function media()
    {
        return $this->belongsTo('App\Media', 'idMedia');
    }
}
