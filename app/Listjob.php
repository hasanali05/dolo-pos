<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Listjob extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['checklist_id','job', 'is_done','created_by'];

    protected $auditInclude = [
      'checklist_id',
      'job', 
      'is_done'
    ];

    public function checklist(){
		return $this->belongsTo(Checklist::class);
    }
}