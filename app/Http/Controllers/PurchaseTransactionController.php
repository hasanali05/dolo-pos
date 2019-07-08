<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseTransaction;

class PurchaseTransactionController extends Controller
{
      public function purchaseTransaction(){
    	return view('admin.purchaseTransaction.index');
    }

     public function purchaseTransactionAll()
    {
        $purchases = PurchaseTransaction::with('supplier')->get();
        return response()->json(["purchases"=>$purchases]);
    }
}
