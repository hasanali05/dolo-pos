<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class PurchaseTransaction extends Model
{
    protected $dates = ['deleted_at'];
    protected $table = 'purchase_transactions';

    protected $fillable=['supplier_id','reason','amount'];

    public function purchases(){
    	return $this->hasMany(Supplier::class,'supplier_id');
    }

  
    
}
