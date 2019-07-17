<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseTransaction;
use App\Supplier;

class PurchaseTransactionController extends Controller
{
      public function purchaseTransaction(){
    	return view('admin.purchaseTransaction.index');
    }

     public function purchaseTransactionAll()
    {
        $purchases = PurchaseTransaction::with('supplier')->get();
        return response()->json(["purchases"=>$purchases]);
    }


       public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->purchase, [
            'supplier_id'=>'required',
            'reason'=>'required',
            'amount'=>'required',
            'note'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->purchase['id'] == null){  

            // create

            $purchase = PurchaseTransaction::create([
                'supplier_id' => $request->purchase['supplier_id'],
                'reason' => $request->purchase['reason'],
                'amount' => $request->purchase['amount'],
                'note' => $request->purchase['note'],
            ]);
                
            $purchase = PurchaseTransaction::with('supplier')->find($purchase->id);
            return response()->json(["success"=>true, 'status'=>'created', 'purchase'=>$purchase]);
        } else { 
            return $request;
            $purchase = PurchaseTransaction::find($request->purchase['id']);   
            if(!$purchase) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $purchase->update([
                'supplier_id' => $request->purchase['supplier_id'],
                'reason' => $request->purchase['reason'],
                'amount' => $request->purchase['amount'],
                'note' => $request->purchase['note'],
            ]);
            $purchase = PurchaseTransaction::with('supplier')->find($purchase->id);
            

            return response()->json(["success"=>true, 'status'=>'updated', 'purchase'=>$purchase]);
        }
    }
}
