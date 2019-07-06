<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductCategory;

class ProductController extends Controller
{
    public function products()
    {
    	return view('admin.product.index');
    }

 	 public function productsAll()
    {
        $products = Product::with('category')->get();
        return response()->json(["products"=>$products]);
    }

     public function statusChange(Request $request)
    {
        $product = Product::find($request->product_id);
        if($product) {
        	$product->update([
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
        $validator = \Validator::make($request->product, [
            'name'=>'required|string',
            'category_id'=>'required',
            'detail'=>'required|string',
            'is_active'=>'required|boolean',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->product['id'] == null){  

            // create


            $product = Product::create([
                'name' => $request->product['name'],
                'category_id' => $request->product['category']['id'],
                'detail' => $request->product['detail'],
                'is_active' => $request->product['is_active'],
            ]);

                
            $product = Product::with('category')->find($product->id);
            return response()->json(["success"=>true, 'status'=>'created', 'product'=>$product]);
        } else { 
            $product = Product::find($request->product['id']);   
            if(!$product) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $product->update([
                'name' => $request->product['name'],
                'category_id' => $request->product['category_id'],
                'detail' => $request->product['detail'],
                'is_active' => $request->product['is_active'],
            ]);

            

            return response()->json(["success"=>true, 'status'=>'updated', 'product'=>$product]);
        }
    }
}
