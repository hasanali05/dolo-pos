<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Warranty extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'purchase_id', 'inventory_id', 'sale_id','warranty_duration','warranty_type','warranty_start','warranty_end','issue_date','reason','return_date','status' ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
