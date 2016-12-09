<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'person';

    protected $primaryKey = 'idPerson';
    protected $fillable = [
        'login','password', 'email', 'first_name','last_name','phone_indicator', 'phone', 'confirmation_code', 'type_person'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function tenant()
    {
        return $this->hasOne('App\Tenant', 'idPerson');
    }

    public function photographer()
    {
        return $this->hasOne('App\Photographer', 'idPerson');
    }
}
