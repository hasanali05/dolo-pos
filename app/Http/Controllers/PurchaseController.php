<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;

class PurchaseController extends Controller
{
    public function purchases()
    {
    	return view('admin.purchas.index');
    }

 	 public function purchasesAll()
    {
        $purchases = Purchase::with('supplier')->get();
        return response()->json(["purchases"=>$purchases]);
    }




       public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->purchase, [
            'supplier_id'=>'required',
            'purchase_date'=>'required',
            'amount'=>'required',
            'commission'=>'required',
            'payment'=>'required',
            'due'=>'required',
            'is_active'=>'required|boolean',
        ]);
        


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->purchase['id'] == null){  

            // create


            $purchase = Purchase::create([
            	'supplier_id' => $request->purchase['supplier'],
                'purchase_date' => $request->purchase['purchase_date'],
                'amount' => $request->purchase['amount'],
                'commission' => $request->purchase['commission'],
                'payment' => $request->purchase['payment'],
                'due' => $request->purchase['due'],
                'is_active' => $request->purchase['is_active'],
            ]);

                
            $purchase = Purchase::find($purchase->id);
            return response()->json(["success"=>true, 'status'=>'created', 'purchase'=>$purchase]);
        } else { 
            $purchase = Purchase::find($request->purchase['id']);   
            if(!$purchase) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $purchase->update([
            	'supplier_id' => $request->purchase['supplier_id'],
                'purchase_date' => $request->purchase['purchase_date'],
                'amount' => $request->purchase['amount'],
                'commission' => $request->purchase['commission'],
                'payment' => $request->purchase['payment'],
                'due' => $request->purchase['due'],
                'is_active' => $request->purchase['is_active'],
            ]);

            

            return response()->json(["success"=>true, 'status'=>'updated', 'purchase'=>$purchase]);
        }
    }
}
