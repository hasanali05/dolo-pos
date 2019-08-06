<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaleTransaction;
use App\Customer;
use App\Ledger;
use App\Account;
use Auth;

class SaleTransactionController extends Controller
{
     public function saleTransaction()
    {
       return view('admin.saleTransections.index');
    }

    public function saleTransactionAll()
    {
    	$saleTransactions = SaleTransaction::with('customer')->get();
        return response()->json(["saleTransactions"=>$saleTransactions]);
    }

    public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->saleTransaction, [
            'customer_id'=>'required',
            'account_id'=>'required',
            'amount'=>'required',
            'note'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->saleTransaction['id'] == null){  

            // create
            $saleTransaction = SaleTransaction::create([
                'customer_id' => $request->saleTransaction['customer_id'],
                'reason' => 'collection',
                'amount' => $request->saleTransaction['amount'],
                'note' => $request->saleTransaction['note'],
            ]);



            $customer = Customer::find($request->saleTransaction['customer_id']);

            $ledgerSupplier = new Ledger;
            $ledgerSupplier->entry_date = now();
            $ledgerSupplier->account_id = $customer->account_id;
            $ledgerSupplier->detail = $saleTransaction->id;
            $ledgerSupplier->type = 'collection';

            $ledgerSupplier->debit = 0;
            $ledgerSupplier->credit = $request->saleTransaction['amount'];
            $ledgerSupplier->balance = (-1)*$request->saleTransaction['amount'];

            $ledgerSupplier->created_by = Auth::user()->id;
            $ledgerSupplier->modified_by = Auth::user()->id;
            $ledgerSupplier->save();


            $ledgerTransaction = new Ledger;
            $ledgerTransaction->entry_date = now();
            $ledgerTransaction->account_id = $request->saleTransaction['account_id'];
            $ledgerTransaction->detail = $saleTransaction->id;
            $ledgerTransaction->type = 'collection';

            $ledgerTransaction->debit = $saleTransaction['amount'];
            $ledgerTransaction->credit = 0;
            $ledgerTransaction->balance = $saleTransaction['amount'];

            $ledgerTransaction->created_by = Auth::user()->id;
            $ledgerTransaction->modified_by = Auth::user()->id;
            $ledgerTransaction->save();
                
            $saleTransaction = SaleTransaction::with('customer')->find($saleTransaction->id);
            return response()->json(["success"=>true, 'status'=>'created', 'saleTransaction'=>$saleTransaction]);
        } else { 
            $saleTransaction = SaleTransaction::find($request->saleTransaction['id']);   
            if(!$saleTransaction) return response()->json(["success"=>true, 'status'=>'somethingwrong']);
         
            //update
            $saleTransaction->update([
                'note' => $request->saleTransaction['note'],
            ]);
            $saleTransaction = SaleTransaction::with('customer')->find($saleTransaction->id);
            

            return response()->json(["success"=>true, 'status'=>'updated', 'saleTransaction'=>$saleTransaction]);
        }
    }
}
