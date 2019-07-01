<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class ProductCategory extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'product_categories';

    protected $fillable = ['name','is_active'];




}
