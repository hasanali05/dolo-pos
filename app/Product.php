<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Product extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'products';

    protected $fillable = ['name','category_id','detail','is_active'];


    public function category(){
    	return $this->belongsTo(ProductCategory::class,'cetegory_id');
    }



}
