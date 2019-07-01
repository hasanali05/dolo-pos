<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
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
        'name', 'email', 'created_by', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }


    public function detail()
    {
        return $this->hasOne(EmployeeDetail::class);
    }


    public function interviews()
    {
        return $this->hasMany(Interview::class, 'creator_id')->where('created_by', '=' , 'employee');
    }
}
