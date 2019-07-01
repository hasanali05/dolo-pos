<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Expense extends Model
{
     use SoftDeletes;
    protected $fillable = [ 'account_id', 'title', 'expense_date', 'amount', 'reason', 'type', ];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
