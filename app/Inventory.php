<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Inventory extends Model
{
     protected $dates = ['deleted_at'];
    protected $table = 'inventories';

    protected $fillable=['product_id','unique_code','quantity','buying_price','selling_price','status','supplier_id','purchase_id','customer_id','sale_id'];

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
        return $this->belongsTo(Sale::class,'sale_id');
    }
}
