<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Inventory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'inventories';

    protected $fillable=['product_id','unique_code','quantity', 'sold_quantity', 'qty_type', 'buying_price','selling_price','status','supplier_id','purchase_id','customer_id','sale_id'];

    protected $auditInclude = [
        'product_id',
        'unique_code',
        'quantity',
        'sold_quantity',
        'qty_type',
        'buying_price',
        'selling_price',
        'status',
        'supplier_id',
        'purchase_id',
        'customer_id',
        'sale_id'
    ];

    public function product(){
    	return $this->belongsTo(Product::class,'product_id');
    }

    public function supplier(){
    	return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function customer(){
    	return $this->belongsTo(Customer::class,'customer_id');
    }
    
    public function purchase(){
    	return $this->belongsTo(PurchaseDetail::class, 'purchase_id', 'id');
    }
    public function sale(){
        return $this->belongsTo(SaleDetail::class,'sale_id','id');
    }
    public function damage()
    {
        return $this->hasMany(Damage::class);
    }
}
