<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeDetail;
use Auth; 

class EmployeeDetailController extends Controller
{
	public function employees()
	{
		return view('admin.employees.index');
	}
    public function employeesAll()
    {
        $employees = Employee::with('detail')->get();
        return response()->json(["employees"=>$employees]);
    }
    public function statusChange(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        if($employee) {
        	$employee->update([
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
        $validator = \Validator::make($request->employee, [
            'name'=>'required|string',
            'email'=>'required|email',
            'is_active'=>'required|boolean',
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

        if($request->employee['id'] == null){
            //validate data
            $validator = \Validator::make($request->employee->all(), [
                'password'=>'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
            }

            // create
            $employee = Employee::create([
                'name' => $request->employee['name'],
                'email' => $request->employee['email'],
                'password' => bcrypt($request->employee['password']),
                'created_by' => Auth::id(),
                'is_active' => $request->employee['is_active'],
            ]);
            $employeeDetail=EmployeeDetail::create([
                'employee_id' => $employee->id,
                'full_name' => $request->employee['detail']['full_name'],
                'phone' => $request->employee['detail']['phone'],
                'bitbucket' => $request->employee['detail']['bitbucket'],
                'trello' => $request->employee['detail']['trello'],
                'skype' => $request->employee['detail']['skype'],
                'avatar' =>'default/images/1.jpg',//default
                'designation' => $request->employee['detail']['designation'],
                'join_date' => $request->employee['detail']['join_date'],
                'address' => $request->employee['detail']['address'],
            ]);
            $employee = Employee::with('detail')->find($employee->id);
            return response()->json(["success"=>true, 'status'=>'created', 'employee'=>$employee]);
        } else { 
            $employee = Employee::find($request->employee['id']);   
            if(!$employee) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
            //validate data
            if(array_key_exists('password', $request->employee)){
                $validator = \Validator::make($request->employee->all(), [
                    'password'=>'required|min:6'
                ]);
                
                if ($validator->fails()) {
                    return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
                }

                $employee->update([
                    'password' => bcrypt($request->employee['password']),
                    'created_by' => Auth::id(),
                ]);
            }
            //update
            $employee->update([
                'name' => $request->employee['name'],
                'email' => $request->employee['email'],
                'created_by' => Auth::id(),
                'is_active' => $request->employee['is_active'],
            ]);
            $employeeDetail = $employee->detail;
            $employeeDetail->update([
                'employee_id' => $employee->id,
                'full_name' => $request->employee['detail']['full_name'],
                'phone' => $request->employee['detail']['phone'],
                'bitbucket' => $request->employee['detail']['bitbucket'],
                'trello' => $request->employee['detail']['trello'],
                'skype' => $request->employee['detail']['skype'],
                'avatar' =>'default/images/1.jpg',//default
                'designation' => $request->employee['detail']['designation'],
                'join_date' => $request->employee['detail']['join_date'],
                'address' => $request->employee['detail']['address'],
            ]);
            return response()->json(["success"=>true, 'status'=>'updated', 'employee'=>$employee]);
        }
    }
}
