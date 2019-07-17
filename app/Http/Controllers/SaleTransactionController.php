<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaleTransaction;
use App\Customer;

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
            'reason'=>'required',
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
                'reason' => $request->saleTransaction['reason'],
                'amount' => $request->saleTransaction['amount'],
                'note' => $request->saleTransaction['note'],
            ]);

                
            $saleTransaction = SaleTransaction::with('customer')->find($saleTransaction->id);
            return response()->json(["success"=>true, 'status'=>'created', 'saleTransaction'=>$saleTransaction]);
        } else { 
            $saleTransaction = SaleTransaction::find($request->saleTransaction['id']);   
            if(!$saleTransaction) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $saleTransaction->update([
                'customer_id' => $request->saleTransaction['customer_id'],
                'reason' => $request->saleTransaction['reason'],
                'amount' => $request->saleTransaction['amount'],
                'note' => $request->saleTransaction['note'],
            ]);
             $saleTransaction = SaleTransaction::with('customer')->find($saleTransaction->id);
            

            return response()->json(["success"=>true, 'status'=>'updated', 'saleTransaction'=>$saleTransaction]);
        }
    }
}
