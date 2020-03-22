<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Purchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'purchases';

    protected $fillable=['supplier_id','purchase_date','amount','commission','payment','due'];

    protected $auditInclude = [
        'supplier_id', 
        'purchase_date', 
        'amount', 
        'commission', 
        'payment', 
        'due', 
    ];

    public function supplier(){
    	return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function supplies(){
    	return $this->hasMany(PurchaseDetail::class,'purchase_id','id');
    }

}
