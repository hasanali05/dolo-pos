<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warranty;

class WarrantyController extends Controller
{
      public function warranties()
    {
    	return view('admin.warranties.index');
    }

 	 public function warrantiesAll()
    {
        $warranties = Warranty::with('purchase','inventory','sale')->get();
        return response()->json(["warranties"=>$warranties]);
    }

      public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->warranty, [
            'inventory.id'=>'required',
            'issue_date'=>'required',
            'reason'=>'required',
            'return_date'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->warranty['id'] == null){  

            // create


            $warranty = Warranty::create([
                'inventory_id' => $request->warranty['inventory']['id'],
                'purchase_id' => $request->warranty['inventory']['purchase_id'],
                'sale_id' => $request->warranty['inventory']['sale_id'],
                'warranty_duration' => $request->warranty['inventory']['purchase']['warranty_duration'],
                'warranty_type' => $request->warranty['inventory']['purchase']['warranty_type'],
                'warranty_start' => $request->warranty['inventory']['sale']['warranty_start'],
                'warranty_end' => $request->warranty['inventory']['sale']['warranty_end'],
                'status' =>  $request->warranty['status'],
                'reason' => $request->warranty['reason'],
                'return_date' => $request->warranty['return_date'],
            ]);


                
            $warranty = Warranty::with('purchase','inventory','sale')->find($warranty->id);
            return response()->json(["success"=>true, 'status'=>'created', 'warranty'=>$warranty]);
        } else { 
            $warranty = Warranty::find($request->warranty['id']);   
            if(!$warranty) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $warranty->update([
               'inventory_id' => $request->warranty['inventory']['id'],
                'issue_date' => $request->warranty['issue_date'],
                'reason' => $request->warranty['reason'],
                'return_date' => $request->warranty['return_date'],
            ]);
              $warranty = Warranty::with('purchase','inventory','sale')->find($warranty->id);
            

            return response()->json(["success"=>true, 'status'=>'updated', 'warranty'=>$warranty]);
        }
    }

}
