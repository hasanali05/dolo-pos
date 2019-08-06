<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\PurchaseDetail;
use App\Inventory;
use App\PurchaseTransaction;
use App\Ledger;
use App\Account;
use Auth;

class PurchaseController extends Controller
{
    public function purchases()
    {
        return view('admin.purchase.index');
    }

    public function purchasesAll()
    {
        $purchases = Purchase::with('supplier', 'supplies', 'supplies.product')->get();
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
            'purchase.redeem_date'=>'nullable|date',
            'purchase.convayance'=>'nullable|numeric',
            'purchase.payment'=>'nullable|numeric',
            'purchase.note'=>'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }
        foreach ($request['detail'] as $detail) {
            $validator = \Validator::make($detail, [
                'unique_code'=>'required|string|unique:purchase_details,unique_code',
                'buying_price'=>'required|numeric',
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
            $purchaseDetail = PurchaseDetail::create([
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
                'purchase_id' => $purchaseDetail->id,
            ]);
        }

        $inventoryAccount = Account::where('name', '=', 'Inventory')
            ->where('group', '=', 'Capital')
            ->where('sub_group', '=', 'Capital')
            ->first();

        if(!$inventoryAccount) {
            $inventoryAccount = Account::create([
                'name'=>'Inventory',
                'group'=>'Capital',
                'sub_group'=>'Capital',
                'is_active'=>1,
                'created_by'=>Auth::user()->id,
            ]);
        }

        $ledgerInventory = new Ledger;
        $ledgerInventory->entry_date = $purchaseData['purchase_date'];
        $ledgerInventory->account_id = $inventoryAccount->id;
        $ledgerInventory->detail = $purchase->id;
        $ledgerInventory->type = 'purchase';

        $ledgerInventory->debit = $total;
        $ledgerInventory->credit = 0;
        $ledgerInventory->balance = $total;

        $ledgerInventory->created_by = Auth::user()->id;
        $ledgerInventory->modified_by = Auth::user()->id;
        $ledgerInventory->save();


        $ledgerSupplier = new Ledger;
        $ledgerSupplier->entry_date = $purchaseData['purchase_date'];
        $ledgerSupplier->account_id = $supplier['account_id'];
        $ledgerSupplier->detail = $purchase->id;
        $ledgerSupplier->type = 'purchase';

        $ledgerSupplier->debit = $purchaseData['payment']-$purchaseData['convayance'];
        $ledgerSupplier->credit = $total;
        $ledgerSupplier->balance = $total-$purchaseData['payment']-$purchaseData['convayance'];

        $ledgerSupplier->created_by = Auth::user()->id;
        $ledgerSupplier->modified_by = Auth::user()->id;
        $ledgerSupplier->save();


        if($purchaseData['convayance'] > 0) {
            $convayanceAccount = Account::where('name', '=', 'Convayance')
            ->where('group', '=', 'Capital')
            ->where('sub_group', '=', 'Capital')
            ->first();

            if(!$convayanceAccount) {
                $convayanceAccount = Account::create([
                    'name'=>'Convayance',
                    'group'=>'Capital',
                    'sub_group'=>'Capital',
                    'is_active'=>1,
                    'created_by'=>Auth::user()->id,
                ]);
            }

            $ledgerConvayance = new Ledger;
            $ledgerConvayance->entry_date = $purchaseData['purchase_date'];
            $ledgerConvayance->account_id = $convayanceAccount->id;
            $ledgerConvayance->detail = $purchase->id;
            $ledgerConvayance->type = 'purchase';

            $ledgerConvayance->debit = 0;
            $ledgerConvayance->credit = $purchaseData['convayance'];
            $ledgerConvayance->balance = (-1)*$purchaseData['convayance'];

            $ledgerConvayance->created_by = Auth::user()->id;
            $ledgerConvayance->modified_by = Auth::user()->id;
            $ledgerConvayance->save();
        }
        


        $ledgerAsset = new Ledger;
        $ledgerAsset->entry_date = $purchaseData['purchase_date'];
        $ledgerAsset->account_id = $account['id'];
        $ledgerAsset->detail = $purchase->id;
        $ledgerAsset->type = 'purchase';

        $ledgerAsset->debit = 0;
        $ledgerAsset->credit = $purchaseData['payment'];
        $ledgerAsset->balance = (-1)*$purchaseData['payment'];

        $ledgerAsset->created_by = Auth::user()->id;
        $ledgerAsset->modified_by = Auth::user()->id;
        $ledgerAsset->save();

        // update transaction
        PurchaseTransaction::create([
            'supplier_id' => $supplier['id'],
            'reason' => 'purchase',
            'amount' => (-1)*($total-$purchaseData['convayance']),
            'ledger_id' => $ledgerSupplier->id,
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
            'ledger_id' => $ledgerAsset->id,
            'redeem_date' => $purchaseData['redeem_date'],
        ]);

        return response()->json(["success"=>true, 'status'=>'created']);
    }

    public function purchasesdetail(){
        return view('admin.purchase.create');
    }
}
