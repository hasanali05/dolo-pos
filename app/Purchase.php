<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Purchase extends Model
{
    protected $dates = ['deleted_at'];
    protected $table = 'purchases';

    protected $fillable=['supplier_id','purchase_date','amount','commission','payment','due'];

    public function suppliers(){
    	return $this->hasMany(Supplier::class,'supplier_id');
    }

}
