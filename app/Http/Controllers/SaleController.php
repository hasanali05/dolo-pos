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
    public function salesAll()
    {
        $sales = Sale::with('customer')->get();
        return response()->json(["sales"=>$sales]);
    }
    public function statusChange(Request $request)
    {
        $sale = Sale::find($request->sale_id);
        if($sale) {
        	$sale->update([
        		'is_active' => $request->is_active
        	]);
        	return response()->json(["success"=>true]);
        } else {
        	return response()->json(["success"=>false]);
        }
    }
    public function addOrUpdate(Request $request) 
    {
        //validate data
        $validator = \Validator::make($request->sale, [
            'sale_date'=>'required|date',
            'amount'=>'required|numeric',
            'commission'=>'required|string',
            'payment'=>'required|numeric',
            'due'=>'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->sale['id'] == null){
            // create
            $sale = Sale::create([
                'customer_id' => $request->sale['customer_id'],
                'sale_date' => $request->sale['sale_date'],
                'amount' => $request->sale['amount'],
                'commission' => $request->sale['commission'],
                'payment' => $request->sale['payment'],
                'due' => $request->sale['due'],
                'created_by' => Auth::id(),
                'is_active' => $request->sale['is_active'],
            ]);
            $sale = Sale::with('customer')->find($sale->id);
            return response()->json(["success"=>true, 'status'=>'created', 'sale'=>$sale]);
        } else { 
            $sale = Sale::find($request->sale['id']);   
            if(!$sale) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        

            //update
            $sale->update([
                'customer_id' => $request->sale['customer_id'],
                'sale_date' => $request->sale['sale_date'],
                'amount' => $request->sale['amount'],
                'commission' => $request->sale['commission'],
                'payment' => $request->sale['payment'],
                'due' => $request->sale['due'],
                'created_by' => Auth::id(),
                'is_active' => $request->sale['is_active'],
            ]);
               $sale = Sale::with('customer')->find($sale->id);
            return response()->json(["success"=>true, 'status'=>'updated', 'sale'=>$sale]);
        }
    }
}
