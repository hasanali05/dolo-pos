<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }


    //function overloading for show login form.
    public function showLoginForm()
    {
        return view('admin.pages.login');
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

        //attemt to log the admin in
        if(Auth::guard('admin')->attempt(['email'=> $request->email, 'password'=> $request->password])){
            //if successful, then redirect to their intended location
            return redirect()->intended(route('admin.index'));
        }

        //if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email'));
    }

    /**
     * Log the admin(admin guard) out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

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

        $email = \App\Admin::where('email', '=', $request->email)->first();
        if ($email) {
            return response()->json(['success' =>true ], 200);
        } else {
            return response()->json(['success' =>false], 200);
        }
    }
}
