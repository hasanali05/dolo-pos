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
    	return $this->belongsTo(Purchase::class,'purchase_id');
    }

    public function inventory(){
    	return $this->belongsTo(Inventory::class,'inventory_id');
    }
    
}
