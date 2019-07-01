<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    protected $fillable = [
        'employee_id', 'full_name', 'phone', 'bitbucket', 'trello', 'skype', 'avatar', 'designation', 'join_date', 'address'
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}