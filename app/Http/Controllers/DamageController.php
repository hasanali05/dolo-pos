<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Damage;
Use App\Product;
Use App\Supplier;


class DamageController extends Controller
{
    public function damages()
    {
    	return view('admin.damage.index');
    }
 
 	public function damagesAll()
    {
        $damages = Damage::with('inventory', 'inventory.product','inventory.product.category', 'inventory.supplier')->get();
        return response()->json(["damages"=>$damages]);
    }
    public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->damage, [
            'inventory_id'=>'required',
            'issue_date'=>'required|date',
            'reason'=>'required|string',
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
                'status' => 'damaged',
            ]);

             $damage = Damage::with('inventory', 'inventory.product', 'inventory.supplier')->find($damage->id);

            return response()->json(["success"=>true, 'status'=>'created', 'damage'=>$damage]);
        } else { 
            $damage = Damage::find($request->damage['id']);   
            if(!$damage) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $damage->update([
                'issue_date' => $request->damage['issue_date'],
                'reason' => $request->damage['reason'],
            ]);
            $damage = Damage::with('inventory')->find($damage->id);

            return response()->json(["success"=>true, 'status'=>'updated', 'damage'=>$damage]);
        }
    }
}
