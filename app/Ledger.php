<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Ledger extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = [ 'entry_date', 'account_id', 'type', 'detail', 'debit', 'credit', 'balance', 'created_by', 'modified_by', 'note'];

    protected $auditInclude = [
        'entry_date', 
        'account_id', 
        'type', 
        'detail', 
        'debit', 
        'credit', 
        'balance', 
        'note'
    ];

    public function account()
    {
    	return $this->belongsTo(Account::class);
    }
}