<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\PurchaseDetail;
use App\Inventory;
use App\PurchaseTransaction;

class PurchaseController extends Controller
{
    public function purchases()
    {
    	return view('admin.purchase.index');
    }

 	 public function purchasesAll()
    {
        $purchases = Purchase::with('supplier')->get();
        return response()->json(["purchases"=>$purchases]);
    }




    public function addOrUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account'=>'required',
            'supplier'=>'required',
            'purchase'=>'required',
            'detail'=>'required',

            'account.id'=>'required|numeric|exists:accounts,id',
            'supplier.id'=>'required|numeric|exists:suppliers,id',

            'purchase.purchase_date'=>'required|date',
            'purchase.convayance'=>'nullable|numeric',
            'purchase.payment'=>'nullable|numeric',
            'purchase.note'=>'nullable|text',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        foreach ($request['detail'] as $detail) {
            $validator = \Validator::make($detail, [
                // 'unique_code'=>'required|string|unique:purchase_details,unique_code',
                // 'buying_price'=>'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
            }
        }

        $supplier = $request->supplier;
        $account = $request->account;
        $purchaseData = $request->purchase;
        // create purchase
        $purchase = Purchase::create([
            'supplier_id' => $supplier['id'],
            'purchase_date' => $purchaseData['purchase_date'],
            'amount' => 0,
            'commission' => 0,
            'payment' => 0,
            'due' => 0,
        ]);
        $total = 0;
        foreach ($request['detail'] as $detail) {
            $product = $detail;
            $total += $product['buying_price'];
            // create details 
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product['id'],
                'price' => $product['buying_price'],
                'warranty_duration' => array_key_exists('warranty_duration', $product)?  $product['warranty_duration'] : 0,
                'warranty_type' => array_key_exists('warranty_type', $product)?  $product['warranty_type']: 'days',
                'unique_code' => $product['unique_code'],
            ]);
            // add inventory
            Inventory::create([
                'product_id' => $product['id'],
                'unique_code' => $product['unique_code'],
                'quantity' => 1,

                'buying_price' => $product['buying_price'],
                'selling_price' => array_key_exists('selling_price', $product)?$product['selling_price']:$product['buying_price'],
                'status' => 'inventory',

                'supplier_id' => $supplier['id'],
                'purchase_id' => $purchase->id,
            ]);
        }
        // update transaction
        PurchaseTransaction::create([
            'supplier_id' => $supplier['id'],
            'reason' => 'purchase',
            'amount' => (-1)*($total-$purchaseData['convayance']),
        ]);
        // update purchase  
        $purchase->update([
            'amount' => $total,
            'commission' => $purchaseData['convayance'],
            'payment' => $purchaseData['payment'],
            'due' => $total-$purchaseData['convayance']-$purchaseData['payment'],
        ]);      
        PurchaseTransaction::create([
            'supplier_id' => $supplier['id'],
            'reason' => 'payment',
            'amount' => $purchaseData['payment'],
            'note' => $purchaseData['note'],
        ]);
        return response()->json(["success"=>true, 'status'=>'created']);
    }

    public function purchasesdetail(){
        return view('admin.purchase.create');
    }
}
