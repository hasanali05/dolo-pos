<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Sale extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = [ 'customer_id', 'sale_date', 'amount', 'commission', 'payment','due', 'next_payment_date' ];

    protected $auditInclude = [
        'customer_id', 
        'sale_date', 
        'amount', 
        'commission', 
        'payment',
        'due'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
    public function warranty()
    {
        return $this->hasMany(Warranty::class);
    }
}
