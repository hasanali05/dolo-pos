<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use OwenIt\Auditing\Contracts\Auditable;

class Checklist extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes;
	protected $fillable = ['name','created_by'];
	
    protected $auditInclude = [
        'name',
	];
	
    public function jobs() {
		return $this->hasMany(Listjob::class,'checklist_id');
    }

    public function users(){
    	return DB::table('checklist_user')
    		 ->join('users', 'users.id', '=', 'checklist_user.user_id')
    	->where('checklist_id', $this->id) 
    	->select('users.*')
    	->get();
    }
}
