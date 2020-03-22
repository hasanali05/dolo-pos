<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Customer;
use App\SaleDetail;
use App\SaleTransaction;
use App\Inventory;
use App\Ledger;
use App\Account;
use Auth;

class SaleController extends Controller
{
     public function sales()
    {
        return view('admin.sales.index');
    } 

    public function salesdetail()
	{
		return view('admin.sales.create');
	}
    public function salesAll()
    {
        $sales = Sale::with('customer', 'details', 'details.inventory.product')->get();
        return response()->json(["sales"=>$sales]);
    }

    public function addOrUpdate(Request $request) 
    {        
        $validator = \Validator::make($request->all(), [
            'account'=>'required',
            'customer'=>'required',
            'sale'=>'required',
            'detail'=>'required',

            'account.id'=>'required|numeric|exists:accounts,id',
            'customer.id'=>'required|numeric|exists:customers,id',

            'sale.sale_date'=>'required|date',
            'sale.convayance'=>'nullable|numeric',
            'sale.payment'=>'nullable|numeric',
            'sale.note'=>'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }
        foreach ($request['detail'] as $detail) {
            $validator = \Validator::make($detail, [
                'qty_type'=>'required|string|in:unique,quantity',
                'selling_price'=>'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
            }
            
            if ($detail['qty_type'] == 'quantity') {
                $validator = \Validator::make($detail, [
                    'sold_quantity'=>'required|numeric|min:1',
                ]);
            }

            if ($validator->fails()) {
                return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
            }
        }
        $customer = $request->customer;
        $account = $request->account;
        $saleData = $request->sale;
        // create sale
        $sale = Sale::create([
            'customer_id' => $customer['id'],
            'sale_date' => $saleData['sale_date'],
            'next_payment_date' => $saleData['next_payment_date'] ?? null,
            'amount' => 0,
            'commission' => 0,
            'payment' => 0,
            'due' => 0,
        ]);
        $total = 0;
        $total_buying_price = 0;
        foreach ($request['detail'] as $detail) {
            $inventory = $detail;
            $product = $detail['product'];
            if ($inventory['qty_type'] == 'quantity') {
                $total += $inventory['selling_price'] * $inventory['sold_quantity'];
            } else {
                $total += $inventory['selling_price'];
            }
            $total_buying_price += $inventory['buying_price'];
            $days = 0;
            if(array_key_exists('purchase', $inventory) && $inventory['purchase']['warranty_type'] == 'days') {
                $days = $inventory['purchase']['warranty_duration'];
            } else if(array_key_exists('purchase', $inventory) && $inventory['purchase']['warranty_type'] == 'months') {
                $days = $inventory['purchase']['warranty_duration']*30;
            } else if(array_key_exists('purchase', $inventory) && $inventory['purchase']['warranty_type'] == 'years') {
                $days = $inventory['purchase']['warranty_duration']*365;
            }
            // create details 
            $sale_detail = SaleDetail::create([
                'sale_id' => $sale->id,
                'inventory_id' => $inventory['id'],
                'price' => $inventory['selling_price'],
                'warranty_duration' => array_key_exists('purchase', $inventory)?  $inventory['purchase']['warranty_duration'] : 0,
                'warranty_type' => array_key_exists('purchase', $inventory)?  $inventory['purchase']['warranty_type']: 'days',
                'warranty_start' => now(),
                'warranty_end' => now()->add($days, 'day'),
                'unique_code' => $inventory['unique_code'],
                'quantity' => $inventory['quantity'],
            ]);
            // update inventory
            $inventoryArray = 
            [
                'selling_price' => $inventory['selling_price'],
                'status' => 'sold',
                'customer_id' => $customer['id'],
                'sale_id' => $sale_detail->id,
            ];    

            if ($inventory['qty_type'] == 'quantity') {
                $inventoryArray['quantity'] = $inventory['quantity'] - $inventory['sold_quantity'];
                $inventoryArray['sold_quantity'] = $inventory['sold_quantity'];
                if ($inventory['quantity'] - $inventory['sold_quantity'] > 0) {                    
                    $inventoryArray['status'] = 'inventory';
                }
            }

            Inventory::where('id','=',$inventory['id'])->update($inventoryArray );
        }
        // update transaction
        SaleTransaction::create([
            'customer_id' => $customer['id'],
            'reason' => 'sale',
            'amount' => (-1)*($total-$saleData['convayance']),
        ]);
        // update sale  
        $sale->update([
            'amount' => $total,
            'commission' => $saleData['convayance'] ?? 0,
            'payment' => $saleData['payment'],
            'due' => $total-$saleData['convayance']-$saleData['payment'],
        ]);      
        SaleTransaction::create([
            'customer_id' => $customer['id'],
            'reason' => 'collection',
            'amount' => $saleData['payment'],
            'note' => $saleData['note'],
        ]);

        // asset account. cash  +      
        $ledgerAsset = new Ledger;
        $ledgerAsset->entry_date = $saleData['sale_date'];
        $ledgerAsset->account_id = $account['id'];
        $ledgerAsset->detail = $sale->id;
        $ledgerAsset->type = 'sale';

        $ledgerAsset->debit = $saleData['payment'];
        $ledgerAsset->credit = 0;
        $ledgerAsset->balance = $saleData['payment'];

        $ledgerAsset->created_by = Auth::user()->id;
        $ledgerAsset->modified_by = Auth::user()->id;
        $ledgerAsset->save();
        // hit inventory -
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
        $ledgerInventory->entry_date = $saleData['sale_date'];
        $ledgerInventory->account_id = $inventoryAccount->id;
        $ledgerInventory->detail = $sale->id;
        $ledgerInventory->type = 'sale';

        $ledgerInventory->debit = 0;
        $ledgerInventory->credit = $total_buying_price;
        $ledgerInventory->balance = (-1)*$total_buying_price;

        $ledgerInventory->created_by = Auth::user()->id;
        $ledgerInventory->modified_by = Auth::user()->id;
        $ledgerInventory->save();
        // profit loss +/-

        $profitLossAccount = Account::where('name', '=', 'Profit & Loss')
            ->where('group', '=', 'Capital')
            ->where('sub_group', '=', 'Profit & Loss')
            ->first();

            if(!$profitLossAccount) {
                $profitLossAccount = Account::create([
                    'name'=>'Profit & Loss',
                    'group'=>'Capital',
                    'sub_group'=>'Profit & Loss',
                    'is_active'=>1,
                    'created_by'=>Auth::user()->id,
                ]);
            }
        if($total >= $total_buying_price){
            // profit
            $ledgerProfitLoss = new Ledger;
            $ledgerProfitLoss->entry_date = $saleData['sale_date'];
            $ledgerProfitLoss->account_id = $profitLossAccount->id;
            $ledgerProfitLoss->detail = $sale->id;
            $ledgerProfitLoss->type = 'sale';

            $ledgerProfitLoss->debit = 0;
            $ledgerProfitLoss->credit = $total-$total_buying_price;
            $ledgerProfitLoss->balance = (-1)*($total-$total_buying_price);

            $ledgerProfitLoss->created_by = Auth::user()->id;
            $ledgerProfitLoss->modified_by = Auth::user()->id;
            $ledgerProfitLoss->save();
        } else {
            // loss
            $ledgerProfitLoss = new Ledger;
            $ledgerProfitLoss->entry_date = $saleData['sale_date'];
            $ledgerProfitLoss->account_id = $profitLossAccount->id;
            $ledgerProfitLoss->detail = $sale->id;
            $ledgerProfitLoss->type = 'sale';

            $ledgerProfitLoss->debit = $total-$total_buying_price;
            $ledgerProfitLoss->credit = 0;
            $ledgerProfitLoss->balance = $total-$total_buying_price;

            $ledgerProfitLoss->created_by = Auth::user()->id;
            $ledgerProfitLoss->modified_by = Auth::user()->id;
            $ledgerProfitLoss->save();
        }
        // customer transaction with receivable(opt) +/- 
        $ledgerCustomer = new Ledger;
        $ledgerCustomer->entry_date = $saleData['sale_date'];
        $ledgerCustomer->account_id = $customer['account_id'];
        $ledgerCustomer->detail = $sale->id;
        $ledgerCustomer->type = 'sale';

        $ledgerCustomer->debit = $total-$saleData['convayance'];
        $ledgerCustomer->credit = $saleData['payment'];
        $ledgerCustomer->balance = $total-$saleData['payment']-$saleData['convayance'];

        $ledgerCustomer->created_by = Auth::user()->id;
        $ledgerCustomer->modified_by = Auth::user()->id;
        $ledgerCustomer->save();
        // convyance + (opt)
        if($saleData['convayance'] > 0) {
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
            $ledgerConvayance->entry_date = $saleData['sale_date'];
            $ledgerConvayance->account_id = $convayanceAccount->id;
            $ledgerConvayance->detail = $sale->id;
            $ledgerConvayance->type = 'sale';

            $ledgerConvayance->debit = $saleData['convayance'];
            $ledgerConvayance->credit = 0;
            $ledgerConvayance->balance = $saleData['convayance'];

            $ledgerConvayance->created_by = Auth::user()->id;
            $ledgerConvayance->modified_by = Auth::user()->id;
            $ledgerConvayance->save();
        }

        return response()->json(["success"=>true, 'status'=>'created']);
    }
}
