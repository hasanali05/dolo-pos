<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class Warranty extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = [ 'purchase_id', 'inventory_id', 'sale_id','warranty_duration','warranty_type','warranty_start','warranty_end','issue_date','reason','return_date','status' ];
    
    protected $auditInclude = [
        'purchase_id', 
        'inventory_id', 
        'sale_id',
        'warranty_duration',
        'warranty_type',
        'warranty_start',
        'warranty_end',
        'issue_date',
        'reason',
        'return_date',
        'status'
    ];

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
