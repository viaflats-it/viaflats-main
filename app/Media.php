<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    //
    protected $table= 'Media';

    protected $primaryKey = 'idMedia';

    protected $fillable = [
        'idMedia','type', 'content',
    ];

    protected $dates = ['date'];

    public $timestamps = false;


    public function media_room()
    {
        return $this->hasOne('App\Media_room', 'idMedia');
    }

}
