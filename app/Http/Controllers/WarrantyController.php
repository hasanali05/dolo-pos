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

}
