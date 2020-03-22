<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function customers()
    {
    	return view('admin.customer.index');
    }

 	 public function customersAll()
    {
        $customers = Customer::with('account')->get();
        foreach ($customers as $customer) {
            $customer['due'] = $customer->due;
        }
        return response()->json(["customers"=>$customers]);
    }

     public function statusChange(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        if($customer) {
        	$customer->update([
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
        $validator = \Validator::make($request->customer, [
            'name'=>'required|string',
            'account_id'=>'required',
            'contact'=>'required|string',
            'address'=>'required|string',
            'is_active'=>'required|boolean',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->customer['id'] == null){  

            // create


            $customer = Customer::create([
            	'account_id' => $request->customer['account_id'],
                'name' => $request->customer['name'],
                'contact' => $request->customer['contact'],
                'address' => $request->customer['address'],
                'is_active' => $request->customer['is_active'],
            ]);

                
            $customer = Customer::with('account')->find($customer->id);
            return response()->json(["success"=>true, 'status'=>'created', 'customer'=>$customer]);
        } else { 
            $customer = Customer::find($request->customer['id']);   
            if(!$customer) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $customer->update([
            	'account_id' => $request->customer['account_id'],
                'name' => $request->customer['name'],
                'contact' => $request->customer['contact'],
                'address' => $request->customer['address'],
                'is_active' => $request->customer['is_active'],
            ]);
            $customer = Customer::with('account')->find($customer->id);

            return response()->json(["success"=>true, 'status'=>'updated', 'customer'=>$customer]);
        }
    }
}
