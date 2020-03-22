<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','group','sub_group', 'is_active','created_by'];

    public function ledgers(){
    	return $this->hasMany(Ledger::class);
    }

    public function getBalanceAttribute($value)
    {
        return $this->ledgers->sum('balance');
    }
}
