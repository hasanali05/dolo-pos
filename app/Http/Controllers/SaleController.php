<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Customer;
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
            'sale.note'=>'nullable|text',
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
            $product = $detail;
            $total += $product['buying_price'];
            // create details 
            saleDetail::create([
                'sale_id' => $sale->id,
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

                'customer_id' => $customer['id'],
                'sale_id' => $sale->id,
            ]);
        }
        // update transaction
        saleTransaction::create([
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
        saleTransaction::create([
            'customer_id' => $customer['id'],
            'reason' => 'payment',
            'amount' => $saleData['payment'],
            'note' => $saleData['note'],
        ]);
        return response()->json(["success"=>true, 'status'=>'created']);
    }
}
