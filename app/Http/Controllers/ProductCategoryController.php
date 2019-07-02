<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;

class ProductCategoryController extends Controller
{
    public function productCategories(){
    	return view('admin.productCategory.index');
    }

        public function productCategoriesAll()
    {
        $categories = ProductCategory::all();
        return response()->json(["categories"=>$categories]);
    }


        public function statusChange(Request $request)
    {
        $category = ProductCategory::find($request->productcategory_id);
        if($category) {
        	$category->update([
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
        $validator = \Validator::make($request->category, [
            'name'=>'required|string',
            'is_active'=>'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->category['id'] == null){  

            // create
            $category = ProductCategory::create([
                'name' => $request->category['name'],
                'is_active' => $request->category['is_active'],
            ]);
            $category = ProductCategory::find($category->id);
            return response()->json(["success"=>true, 'status'=>'created', 'category'=>$category]);
        } else { 
            $category = ProductCategory::find($request->category['id']);   
            if(!$category) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $category->update([
                'name' => $request->category['name'],
                'is_active' => $request->category['is_active'],
            ]);

            return response()->json(["success"=>true, 'status'=>'updated', 'category'=>$category]);
        }
    }

}
