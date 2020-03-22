<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Damage extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = [ 'inventory_id', 'issue_date', 'reason', 'status', 'quantity' ];

    protected $auditInclude = [
        'inventory_id',
        'issue_date',
        'reason',
        'status',
        'quantity',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
