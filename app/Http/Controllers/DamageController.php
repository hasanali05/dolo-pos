<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Damage;
Use App\Product;
Use App\Supplier;
Use App\Inventory;
use App\Ledger;
use App\Account;
use Auth;


class DamageController extends Controller
{
    public function damages()
    {
    	return view('admin.damage.index');
    }
 
 	public function damagesAll()
    {
        $damages = Damage::with('inventory', 'inventory.product','inventory.product.category', 'inventory.supplier')->get();
        return response()->json(["damages"=>$damages]);
    }
    public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->damage, [
            'inventory_id'=>'required',
            'issue_date'=>'required|date',
            'reason'=>'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->damage['id'] == null){  
            // create

            $inventory = Inventory::find($request->damage['inventory_id']);
            if($inventory) {
                $damage = Damage::create([
                	'inventory_id' => $request->damage['inventory_id'],
                    'issue_date' => $request->damage['issue_date'],
                    'reason' => $request->damage['reason'],
                    'status' => 'damaged',
                ]);

                $inventory->update([
                    'status'=>'damaged'
                ]);

                // hit inventory -
                $inventoryAccount = Account::where('name', '=', 'Inventory')
                    ->where('group', '=', 'Capital')
                    ->where('sub_group', '=', 'Capital')
                    ->first();

                if(!$inventoryAccount) {
                    $inventoryAccount = Account::create([
                        'name'=>'Inventory',
                        'group'=>'Capital',
                        'sub_group'=>'Capital',
                        'is_active'=>1,
                        'created_by'=>Auth::user()->id,
                    ]);
                }

                $ledgerInventory = new Ledger;
                $ledgerInventory->entry_date = $request->damage['issue_date'];
                $ledgerInventory->account_id = $inventoryAccount->id;
                $ledgerInventory->detail = $damage->id;
                $ledgerInventory->type = 'damage';

                $ledgerInventory->debit = 0;
                $ledgerInventory->credit = $inventory->buying_price;
                $ledgerInventory->balance = (-1)*$inventory->buying_price;

                $ledgerInventory->created_by = Auth::user()->id;
                $ledgerInventory->modified_by = Auth::user()->id;
                $ledgerInventory->save();

                // hit damage -
                $inventoryDamageAccount = Account::where('name', '=', 'Inventory Damages')
                    ->where('group', '=', 'Asset')
                    ->where('sub_group', '=', 'Capital')
                    ->first();

                if(!$inventoryDamageAccount) {
                    $inventoryDamageAccount = Account::create([
                        'name'=>'Inventory Damages',
                        'group'=>'Asset',
                        'sub_group'=>'Capital',
                        'is_active'=>1,
                        'created_by'=>Auth::user()->id,
                    ]);
                }

                $ledgerInventoryDamage = new Ledger;
                $ledgerInventoryDamage->entry_date = $request->damage['issue_date'];
                $ledgerInventoryDamage->account_id = $inventoryDamageAccount->id;
                $ledgerInventoryDamage->detail = $damage->id;
                $ledgerInventoryDamage->type = 'damage';

                $ledgerInventoryDamage->debit = $inventory->buying_price;
                $ledgerInventoryDamage->credit = 0;
                $ledgerInventoryDamage->balance = $inventory->buying_price;

                $ledgerInventoryDamage->created_by = Auth::user()->id;
                $ledgerInventoryDamage->modified_by = Auth::user()->id;
                $ledgerInventoryDamage->save();
            }

            $damage = Damage::with('inventory', 'inventory.product', 'inventory.supplier')->find($damage->id);

            return response()->json(["success"=>true, 'status'=>'created', 'damage'=>$damage]);
        } else { 
            $damage = Damage::find($request->damage['id']);   
            if(!$damage) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $damage->update([
                'issue_date' => $request->damage['issue_date'],
                'reason' => $request->damage['reason'],
            ]);
            $damage = Damage::with('inventory')->find($damage->id);

            return response()->json(["success"=>true, 'status'=>'updated', 'damage'=>$damage]);
        }
    }
}
