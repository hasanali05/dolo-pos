<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class EmployeeLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:employee')->except('employeeLogout');
    }


    //function overloading for show login form.
    public function showLoginForm()
    {
        return view('employee.pages.login');
    }


    /**
     * Functionalities for login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //validate data
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        //attemt to log the employee in
        if(Auth::guard('employee')->attempt(['email'=> $request->email, 'password'=> $request->password])){
            //if successful, then redirect to their intended location
            return redirect()->intended(route('employee.index'));
        }

        //if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email'));
    }

    /**
     * Log the employee(employee guard) out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function employeeLogout(Request $request)
    {
        Auth::guard('employee')->logout();

        return redirect('/');
    }

    public function emailCheck(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()], 422);
        }

        $email = \App\Employee::where('email', '=', $request->email)->first();
        if ($email) {
            return response()->json(['success' =>true ], 200);
        } else {
            return response()->json(['success' =>false], 200);
        }
    }
}
