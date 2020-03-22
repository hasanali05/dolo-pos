<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SaleTransaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = [ 'customer_id', 'reason', 'amount','note' ];

    protected $auditInclude = [
        'customer_id', 
        'reason', 
        'amount',
        'note' 
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
}
