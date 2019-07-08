<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Customer;

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
            'name'=>'required|string',
            'group'=>'required|string',
            'sub_group'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->sale['id'] == null){
            // create
            $sale = Sale::create([
                'name' => $request->sale['name'],
                'group' => $request->sale['group'],
                'sub_group' => $request->sale['sub_group'],
                'created_by' => Auth::id(),
                'is_active' => $request->sale['is_active'],
            ]);
            $sale = Sale::find($sale->id);
            return response()->json(["success"=>true, 'status'=>'created', 'sale'=>$sale]);
        } else { 
            $sale = Sale::find($request->sale['id']);   
            if(!$sale) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        

            //update
            $sale->update([
                'name' => $request->sale['name'],
                'group' => $request->sale['group'],
                'sub_group' => $request->sale['sub_group'],
                'created_by' => Auth::id(),
                'is_active' => $request->sale['is_active'],
            ]);
            return response()->json(["success"=>true, 'status'=>'updated', 'sale'=>$sale]);
        }
    }
}
