<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'purchases';

    protected $fillable=['supplier_id','purchase_date','amount','commission','payment','due'];

    public function supplier(){
    	return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function supplies(){
    	return $this->hasMany(PurchaseDetail::class,'purchase_id','id');
    }

}
