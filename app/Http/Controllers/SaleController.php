<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Customer;
use App\SaleDetail;
use App\SaleTransaction;
use App\Inventory;
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
        $sales = Sale::with('customer')->get();
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
                // 'unique_code'=>'required|string|unique:sale_details,unique_code',
                // 'buying_price'=>'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
            }
        }
        $customer = $request->customer;
        $account = $request->account;
        $saleData = $request->sale;
        // create sale
        $sale = sale::create([
            'customer_id' => $customer['id'],
            'sale_date' => $saleData['sale_date'],
            'amount' => 0,
            'commission' => 0,
            'payment' => 0,
            'due' => 0,
        ]);
        $total = 0;
        foreach ($request['detail'] as $detail) {
            $inventory = $detail;
            $product = $detail['product'];
            $total += $inventory['selling_price'];
            $days = 0;
            if(array_key_exists('purchase', $inventory) && $inventory['purchase']['warranty_type'] == 'days') {
                $days = $inventory['purchase']['warranty_duration'];
            } else if(array_key_exists('purchase', $inventory) && $inventory['purchase']['warranty_type'] == 'months') {
                $days = $inventory['purchase']['warranty_duration']*30;
            } else if(array_key_exists('purchase', $inventory) && $inventory['purchase']['warranty_type'] == 'years') {
                $days = $inventory['purchase']['warranty_duration']*365;
            }
            // create details 
            SaleDetail::create([
                'sale_id' => $sale->id,
                'inventory_id' => $inventory['id'],
                'price' => $inventory['selling_price'],
                'warranty_duration' => array_key_exists('purchase', $inventory)?  $inventory['purchase']['warranty_duration'] : 0,
                'warranty_type' => array_key_exists('purchase', $inventory)?  $inventory['purchase']['warranty_type']: 'days',
                'warranty_start' => now(),
                'warranty_end' => now()->add($days, 'day'),
                'unique_code' => $inventory['unique_code'],
            ]);
            // update inventory
            Inventory::where('id','=',$inventory['id'])->update([
                'selling_price' => $inventory['selling_price'],
                'status' => 'sold',

                'customer_id' => $customer['id'],
                'sale_id' => $sale->id,
            ]);
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
            'commission' => $saleData['convayance'],
            'payment' => $saleData['payment'],
            'due' => $total-$saleData['convayance']-$saleData['payment'],
        ]);      
        SaleTransaction::create([
            'customer_id' => $customer['id'],
            'reason' => 'collection',
            'amount' => $saleData['payment'],
            'note' => $saleData['note'],
        ]);
        return response()->json(["success"=>true, 'status'=>'created']);
    }
}
