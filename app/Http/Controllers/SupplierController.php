<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
{
    public function suppliers()
    {
    	return view('admin.supplier.index');
    }

 	 public function suppliersAll()
    {
        $suppliers = Supplier::with('account')->get();
        return response()->json(["suppliers"=>$suppliers]);
    }

     public function statusChange(Request $request)
    {
        $supplier = Supplier::find($request->supplier_id);
        if($supplier) {
        	$supplier->update([
        		'is_active' => $request->is_active
        	]);
        	return response()->json(["success"=>true]);
        } else {
        	return response()->json(["success"=>false]);
        }
    }


       public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->supplier, [
            'name'=>'required|string',
            'account_id'=>'required',
            'contact'=>'required|string',
            'address'=>'required|string',
            'is_active'=>'required|boolean',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->supplier['id'] == null){  

            // create


            $supplier = Supplier::create([
            	'account_id' => $request->supplier['account_id'],
                'name' => $request->supplier['name'],
                'contact' => $request->supplier['contact'],
                'address' => $request->supplier['address'],
                'is_active' => $request->supplier['is_active'],
            ]);

                
            $supplier = Supplier::find($supplier->id);
            return response()->json(["success"=>true, 'status'=>'created', 'supplier'=>$supplier]);
        } else { 
            $supplier = Supplier::find($request->supplier['id']);   
            if(!$supplier) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $supplier->update([
            	'account_id' => $request->supplier['account_id'],
                'name' => $request->supplier['name'],
                'contact' => $request->supplier['contact'],
                'address' => $request->supplier['address'],
                'is_active' => $request->supplier['is_active'],
            ]);

            

            return response()->json(["success"=>true, 'status'=>'updated', 'supplier'=>$supplier]);
        }
    }
}
