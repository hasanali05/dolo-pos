<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'account_id', 'name', 'contact', 'address', 'is_active', ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    public function getDueAttribute($value)
    {
        return $this->sale->sum('due');
    }
}
