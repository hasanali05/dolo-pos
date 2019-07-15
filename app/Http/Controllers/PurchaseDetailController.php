<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseDetail;


class PurchaseDetailController extends Controller
{
    public function purchasesDetail()
    {
    	return view('admin.purchasesdetail.index');
    }

 	 public function purchasesDetailAll()
    {
        $purchasesDetails = PurchaseDetail::with('purchase','inventory')->get();
        return response()->json(["purchasesDetails"=>$purchasesDetails]);
    }

}
