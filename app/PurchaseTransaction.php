<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseTransaction extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'purchase_transactions';

    protected $fillable=['supplier_id','reason','amount','note','redeem_date','ledger_id','redeem_status'];

    public function supplier(){
    	return $this->belongsTo(Supplier::class,'supplier_id');
    }
}
