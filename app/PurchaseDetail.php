<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class PurchaseDetail extends Model
{
      protected $dates = ['deleted_at'];
    protected $table = 'purchase_details';

    protected $fillable=['purchase_id','inventory_id','price','warranty_duration','warranty_type','unique_code'];

    public function purchase(){
    	return $this->hasMany(Purches::class,'purchase_id');
    }

    public function inventoris(){
    	return $this->hasMany(Inventory::class,'inventory_id');
    }
    
}
