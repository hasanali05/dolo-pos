<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Damage;

class DamageController extends Controller
{
    public function damages()
    {
    	return view('admin.damage.index');
    }
 
 	public function damagesAll()
    {
        $damages = Damage::with('inventory')->get();
        return response()->json(["damages"=>$damages]);
    }
    public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->damage, [
            'inventory_id'=>'required',
            'issue_date'=>'required|string',
            'reason'=>'required|string',
            'status'=>'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->damage['id'] == null){  

            // create


            $damage = Damage::create([
            	'inventory_id' => $request->damage['inventory_id'],
                'issue_date' => $request->damage['issue_date'],
                'reason' => $request->damage['reason'],
                'status' => $request->damage['status'],
            ]);

             $damage = Damage::with('account')->find($damage->id);

            return response()->json(["success"=>true, 'status'=>'created', 'damage'=>$damage]);
        } else { 
            $damage = Damage::find($request->damage['id']);   
            if(!$damage) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $damage->update([
          	 'inventory_id' => $request->damage['inventory_id'],
                'issue_date' => $request->damage['issue_date'],
                'reason' => $request->damage['reason'],
                'status' => $request->damage['status'],
            ]);
            $damage = Damage::with('inventory')->find($damage->id);

            return response()->json(["success"=>true, 'status'=>'updated', 'damage'=>$damage]);
        }
    }
}
