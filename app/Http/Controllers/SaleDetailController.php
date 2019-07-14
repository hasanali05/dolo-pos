<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaleDetail;


class SaleDetailController extends Controller
{
    
    public function salesDetails()
    {
       return view('admin.SaleDetails.index');
    }

    public function salesDetailAll()
    {
    	$saleDetails = SaleDetail::with('sale','inventory')->get();
        return response()->json(["saleDetails"=>$saleDetails]);
    }
}
