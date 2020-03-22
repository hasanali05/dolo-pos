<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class Expense extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = [ 'account_id', 'title', 'expense_date', 'amount', 'reason', 'type', ];

    protected $auditInclude = [
        'account_id',
        'title',
        'expense_date',
        'amount',
        'reason',
        'type',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
