<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

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
            'email'=>'required|email',
            'is_active'=>'required|boolean',
        ]);
        $validator = \Validator::make($request->account['detail'], [
            'full_name'=>'nullable',
            'phone'=>'required',
            'bitbucket'=>'required|email',
            'trello'=>'required|email',
            'skype'=>'required|string',
            'designation'=>'required|string',
            'join_date'=>'required|date',
            'address'=>'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->account['id'] == null){
            //validate data
            $validator = \Validator::make($request->account->all(), [
                'password'=>'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
            }

            // create
            $account = Account::create([
                'name' => $request->account['name'],
                'email' => $request->account['email'],
                'password' => bcrypt($request->account['password']),
                'created_by' => Auth::id(),
                'is_active' => $request->account['is_active'],
            ]);
            $account = Account::find($account->id);
            return response()->json(["success"=>true, 'status'=>'created', 'account'=>$account]);
        } else { 
            $account = Account::find($request->account['id']);   
            if(!$account) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
            //validate data
            if(array_key_exists('password', $request->account)){
                $validator = \Validator::make($request->account->all(), [
                    'password'=>'required|min:6'
                ]);
                
                if ($validator->fails()) {
                    return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
                }

                $account->update([
                    'password' => bcrypt($request->account['password']),
                    'created_by' => Auth::id(),
                ]);
            }
            //update
            $account->update([
                'name' => $request->account['name'],
                'email' => $request->account['email'],
                'created_by' => Auth::id(),
                'is_active' => $request->account['is_active'],
            ]);
            $accountDetail = $account->detail;
            $accountDetail->update([
                'account_id' => $account->id,
                'full_name' => $request->account['detail']['full_name'],
                'phone' => $request->account['detail']['phone'],
                'bitbucket' => $request->account['detail']['bitbucket'],
                'trello' => $request->account['detail']['trello'],
                'skype' => $request->account['detail']['skype'],
                'avatar' =>'default/images/1.jpg',//default
                'designation' => $request->account['detail']['designation'],
                'join_date' => $request->account['detail']['join_date'],
                'address' => $request->account['detail']['address'],
            ]);
            return response()->json(["success"=>true, 'status'=>'updated', 'account'=>$account]);
        }
    }
}
