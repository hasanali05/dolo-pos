<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;

class InventoryController extends Controller
{
    public function purchases(){
    	return view('admin.inventory.index');
    }

     public function inventoriesAll()
    {
        $inventories = Inventory::with('product', 'product.category','supplier','customer','purchase','sale')->get();
        return response()->json(["inventories"=>$inventories]);
    }
}
