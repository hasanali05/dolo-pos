<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PurchaseTransaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'purchase_transactions';

    protected $fillable=['supplier_id','reason','amount','note','redeem_date','ledger_id','redeem_status'];

    protected $auditInclude = [
        'supplier_id',
        'reason',
        'amount',
        'note',
        'redeem_date',
        'ledger_id',
        'redeem_status'
    ];

    public function supplier(){
    	return $this->belongsTo(Supplier::class,'supplier_id');
    }
}
