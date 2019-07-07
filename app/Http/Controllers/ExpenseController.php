<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;

class ExpenseController extends Controller
{
    public function expenses()
    {
    	return view('admin.Expense.index');
    }

 	 public function expensesAll()
    {
        $expenses = Expense::with('account')->get();
        return response()->json(["expenses"=>$expenses]);
    }



       public function addOrUpdate(Request $request)
    {
        //validate data
        $validator = \Validator::make($request->expense, [
            'account_id'=>'required',
            'title'=>'required|string',
            'expense_date'=>'required|string',
            'amount'=>'required|numeric',
            'reason'=>'required',
            'type'=>'required|in:regular,unusual',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->expense['id'] == null){  

            // create


            $expense = Expense::create([
            	'account_id' => $request->expense['account_id'],
                'title' => $request->expense['title'],
                'expense_date' => $request->expense['expense_date'],
                'amount' => $request->expense['amount'],
                'reason' => $request->expense['reason'],
                'type' => $request->expense['type'],
            ]);

             $expense = Expense::with('account')->find($expense->id);

            return response()->json(["success"=>true, 'status'=>'created', 'expense'=>$expense]);
        } else { 
            $expense = Expense::find($request->expense['id']);   
            if(!$expense) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            //update
            $expense->update([
          	'account_id' => $request->expense['account_id'],
                'title' => $request->expense['title'],
                'expense_date' => $request->expense['expense_date'],
                'amount' => $request->expense['amount'],
                'reason' => $request->expense['reason'],
                'type' => $request->expense['type'],
            ]);
            $expense = Expense::with('account')->find($expense->id);

            return response()->json(["success"=>true, 'status'=>'updated', 'expense'=>$expense]);
        }
    }
}
