<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Employee;

class EmployeeController extends Controller
{
	public function index()
	{
		return view('employee.pages.index');
	}
	public function myprofile()
	{
		return view('employee.pages.myprofile');
	}
	public function page404()
	{
		return view('employee.pages.page404');
	}
	public function updateProfile(Request $request)
	{ 
		//validate data
        $validator = \Validator::make($request->employee, [
            'name'=>'required|email',
            'email'=>'required|email',
        ]);
        $validator = \Validator::make($request->employee['detail'], [
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

        $employee = Auth::user();

        if(!$employee) return response()->json(["success"=>true, 'status'=>'somethingwrong']);

		$employee->update([
            'name' => $request->employee['name'],
            'email' => $request->employee['email'],
        ]);
        $employeeDetail = $employee->detail;
        $employeeDetail->update([
            'employee_id' => $employee->id,
            'full_name' => $request->employee['detail']['full_name'],
            'phone' => $request->employee['detail']['phone'],
            'bitbucket' => $request->employee['detail']['bitbucket'],
            'trello' => $request->employee['detail']['trello'],
            'skype' => $request->employee['detail']['skype'],
            'designation' => $request->employee['detail']['designation'],
            'address' => trim($request->employee['detail']['address']),
        ]);

        $employee = Employee::with('detail')->find(Auth::user()->id);

        return response()->json(['success' =>true, 'user'=>$employee ]);
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
		return view('employee.pages.changePassword');
	}
}
