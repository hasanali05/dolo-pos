<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SaleDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'sale_id', 'inventory_id',  'price', 'warranty_duration', 'warranty_type','warranty_start','warranty_end','unique_code' ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
