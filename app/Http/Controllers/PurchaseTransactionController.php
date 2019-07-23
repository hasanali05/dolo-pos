<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseTransaction;
use App\Supplier;
use App\Ledger;
use App\Account;
use Auth;

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
            'account_id'=>'required',
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
                'reason' => 'payment',
                'amount' => $request->purchase['amount'],
                'note' => $request->purchase['note'],
            ]);

            $supplier = Supplier::find($request->purchase['supplier_id']);

            $ledgerSupplier = new Ledger;
            $ledgerSupplier->entry_date = now();
            $ledgerSupplier->account_id = $supplier->account_id;
            $ledgerSupplier->detail = $purchase->id;
            $ledgerSupplier->type = 'payment';

            $ledgerSupplier->debit = $request->purchase['amount'];
            $ledgerSupplier->credit = 0;
            $ledgerSupplier->balance = $request->purchase['amount'];

            $ledgerSupplier->created_by = Auth::user()->id;
            $ledgerSupplier->modified_by = Auth::user()->id;
            $ledgerSupplier->save();


            $ledgerTransaction = new Ledger;
            $ledgerTransaction->entry_date = now();
            $ledgerTransaction->account_id = $request->purchase['account_id'];
            $ledgerTransaction->detail = $purchase->id;
            $ledgerTransaction->type = 'payment';

            $ledgerTransaction->debit = 0;
            $ledgerTransaction->credit = $purchase['amount'];
            $ledgerTransaction->balance = (-1)*$purchase['amount'];

            $ledgerTransaction->created_by = Auth::user()->id;
            $ledgerTransaction->modified_by = Auth::user()->id;
            $ledgerTransaction->save();



                
            $purchase = PurchaseTransaction::with('supplier')->find($purchase->id);
            return response()->json(["success"=>true, 'status'=>'created', 'purchase'=>$purchase]);
        } else { 
            $purchase = PurchaseTransaction::find($request->purchase['id']);   
            if(!$purchase) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $purchase->update([
                'note' => $request->purchase['note'],
            ]);
            $purchase = PurchaseTransaction::with('supplier')->find($purchase->id);
            

            return response()->json(["success"=>true, 'status'=>'updated', 'purchase'=>$purchase]);
        }
    }
}
