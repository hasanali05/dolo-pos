<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleTransaction extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'customer_id', 'reason', 'amount','note' ];

     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
}
