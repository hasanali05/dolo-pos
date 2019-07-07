<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ledger extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'entry_date', 'account_id', 'type', 'detail', 'debit', 'credit', 'balance', 'created_by', 'modified_by', 'note'];

    public function account()
    {
    	return $this->belongsTo(Account::class);
    }
}