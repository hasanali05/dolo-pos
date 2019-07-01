<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that should be say the guard name.
     *
     * @var array
     */
    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class, 'creator_id')->where('created_by', '=' , 'admin');
    }
}
