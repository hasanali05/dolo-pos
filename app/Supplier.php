<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Supplier extends Model
{
    use softDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'suppliers';

    protected $fillable = ['account_id','name','contact','address','is_active'];

     public function accounts(){
    	return $this->hasMany(Account::class,'account_id');
    }

}
