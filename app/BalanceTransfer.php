<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BalanceTransfer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes;
    protected $fillable = ['from_account_id','to_account_id', 'amount', 'note'];	
    
    protected $auditInclude = [
        'from_account_id',
        'to_account_id', 
        'amount', 
        'note'
    ];

    protected $with = [
        'from', 'to'
    ];
    
    public function from()
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    public function to()
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }
}