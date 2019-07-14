<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaleTransaction;

class SaleTransactionController extends Controller
{
     public function saleTransaction()
    {
       return view('admin.saleTransections.index');
    }

    public function saleTransactionAll()
    {
    	$saleTransactions = SaleTransaction::with('customer')->get();
        return response()->json(["saleTransactions"=>$saleTransactions]);
    }
}
