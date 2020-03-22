<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PurchaseDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'purchase_details';

    protected $fillable=['purchase_id','product_id','price','warranty_duration','warranty_type','unique_code','quantity'];
    
    protected $auditInclude = [
        'purchase_id',
        'product_id',
        'price',
        'warranty_duration',
        'warranty_type',
        'unique_code',
        'quantity'
    ];

    public function purchase(){
    	return $this->belongsTo(Purchase::class,'purchase_id');
    }

    public function product(){
    	return $this->belongsTo(Product::class,'product_id');
    }
    
}
