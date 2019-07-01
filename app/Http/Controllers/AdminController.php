<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
	public function index()
	{
		return view('admin.pages.index');
	}
	public function myprofile()
	{
		return view('admin.pages.myprofile');
	}
	public function updateProfile(Request $request)
	{ 
		//validate data
        $validator = \Validator::make($request->all(), [
            'email'=>'required|email',
            'name'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()], 200);
        }
		$user =Auth::user();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->update();
        return response()->json(['success' =>true, 'user'=>$user ], 200);
	}
	public function changePassword(Request $request)
	{
		if($request->post()){
			//validate data
	        $validator = \Validator::make($request->all(), [
            	'password'=>'required|min:6'
	        ]);

	        if ($validator->fails()) {
	        	return back()->with('errors',$validator->messages());
	        }
			$user =Auth::user();
			$user->password = bcrypt($request->password);
			$user->update();
        	return back()->with('message', "Password updated successfully.");
		}
		return view('admin.pages.changePassword');
	}
	public function page404()
	{
		return view('admin.pages.page404');
	}
}
