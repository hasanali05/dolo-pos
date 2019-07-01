<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Inventory extends Model
{
     protected $dates = ['deleted_at'];
    protected $table = 'inventories';

    protected $fillable=['product_id','unique_code','quantity','buying_price','selling_price','status','supplier_id','supply_id','customer_id','sale_id'];

    public function product(){
    	return $this->belongsTo(Product::class,'product_id');
    }

    public function supplieres(){
    	return $this->hasMany(Supplier::class,'supplier_id');
    }
    public function customers(){
    	return $this->hasMany(Customer::class,'customer_id');
    }
    public function sales(){
    	return $this->hasMany(Sale::class,'sale_id');
    }
    public function supplys(){
    	return $this->hasMany(Supply::class,'supply_id');
    }
}
