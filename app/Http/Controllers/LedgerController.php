<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ledger;
use App\Account;

class LedgerController extends Controller
{
    public function ledgers()
	{
		return view('admin.ledger.index');
	}
    public function ledgersAll()
    {
        $ledgers = Ledger::all();
        $account = Account::all();
        return response()->json(["$ledgers"=>$ledgers],["$account"=>$account]);
    }
    public function statusChange(Request $request)
    {
        $ledger = Ledger::find($request->ledger_id);
        if($ledger) {
        	$ledger->update([
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
        $validator = \Validator::make($request->ledger, [
            'name'=>'required|string',
            'group'=>'required|string',
            'sub_group'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->ledger['id'] == null){
            // create
            $ledger = Ledger::create([
                'name' => $request->ledger['name'],
                'group' => $request->ledger['group'],
                'sub_group' => $request->ledger['sub_group'],
                'created_by' => Auth::id(),
                'is_active' => $request->ledger['is_active'],
            ]);
            $ledger = Ledger::find($ledger->id);
            return response()->json(["success"=>true, 'status'=>'created', 'ledger'=>$ledger]);
        } else { 
            $ledger = Ledger::find($request->ledger['id']);   
            if(!$ledger) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        

            //update
            $ledger->update([
                'name' => $request->ledger['name'],
                'group' => $request->ledger['group'],
                'sub_group' => $request->ledger['sub_group'],
                'created_by' => Auth::id(),
                'is_active' => $request->ledger['is_active'],
            ]);
            return response()->json(["success"=>true, 'status'=>'updated', 'ledger'=>$ledger]);
        }
    }
}
