<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Auth;

class AccountController extends Controller
{
	public function accounts()
	{
		return view('admin.accounts.index');
	}
    public function accountsAll()
    {
        $accounts = Account::all();
        return response()->json(["accounts"=>$accounts]);
    }
    public function statusChange(Request $request)
    {
        $account = Account::find($request->account_id);
        if($account) {
        	$account->update([
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
        $validator = \Validator::make($request->account, [
            'name'=>'required|string',
            'group'=>'required|string',
            'sub_group'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->account['id'] == null){
            // create
            $account = Account::create([
                'name' => $request->account['name'],
                'group' => $request->account['group'],
                'sub_group' => $request->account['sub_group'],
                'created_by' => Auth::id(),
                'is_active' => $request->account['is_active'],
            ]);
            $account = Account::find($account->id);
            return response()->json(["success"=>true, 'status'=>'created', 'account'=>$account]);
        } else { 
            $account = Account::find($request->account['id']);   
            if(!$account) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        

            //update
            $account->update([
                'name' => $request->account['name'],
                'group' => $request->account['group'],
                'sub_group' => $request->account['sub_group'],
                'created_by' => Auth::id(),
                'is_active' => $request->account['is_active'],
            ]);
            return response()->json(["success"=>true, 'status'=>'updated', 'account'=>$account]);
        }
    }
}
