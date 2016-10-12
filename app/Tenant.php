<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table= 'tenant';

    protected $primaryKey = 'idPerson';

    protected $fillable = [
        'idTenant', 'student', 'account_state', 'about', 'spoken_languages', 'nationality', 'idPerson'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = ['creation_date'];

    public function person()
    {
        return $this->hasOne('App\User', 'idPerson');
    }
}
