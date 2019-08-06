<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Damage extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'inventory_id', 'issue_date', 'reason', 'status' ];


    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
