<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'suppliers';

    protected $fillable = ['account_id','name','contact','address','is_active'];

     public function account(){
    	return $this->belongsTo(Account::class,'account_id','id');
    }

}
