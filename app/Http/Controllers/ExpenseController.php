<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Ledger;
use App\Account;
use Auth;

class ExpenseController extends Controller
{
    public function expenses()
    {
    	return view('admin.expense.index');
    }

 	public function expensesAll()
    {
        $expenses = Expense::with('account')->get();
        return response()->json(["expenses"=>$expenses]);
    }

    public function addOrUpdate(Request $request)
    {
        // validate data
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

            $ledger = new Ledger;
            $ledger->entry_date = $request->expense['expense_date'];
            $ledger->account_id = $request->expense['account_id'];
            $ledger->detail = $expense->id;
            $ledger->type = 'expense';

            $ledger->debit = 0;
            $ledger->credit = $request->expense['amount'];
            $ledger->balance = (-1)*$request->expense['amount'];

            $ledger->created_by = Auth::user()->id;
            $ledger->modified_by = Auth::user()->id;
            $ledger->save();


            $expenseAccount = Account::where('name', '=', 'Shop expense')
            ->where('group', '=', 'Expense')
            ->where('sub_group', '=', 'Expense')
            ->first();

            if(!$expenseAccount) {
                $expenseAccount = Account::create([
                    'name'=>'Shop expense',
                    'group'=>'Expense',
                    'sub_group'=>'Expense',
                    'is_active'=>1,
                    'created_by'=>Auth::user()->id,
                ]);
            }

            $ledger = new Ledger;
            $ledger->entry_date = $request->expense['expense_date'];
            $ledger->account_id = $request->account_id;
            $ledger->detail = $expenseAccount->id;
            $ledger->type = 'expense';

            $ledger->debit = $request->expense['amount'];
            $ledger->credit = 0;
            $ledger->balance = $request->expense['amount'];

            $ledger->created_by = Auth::user()->id;
            $ledger->modified_by = Auth::user()->id;
            $ledger->save();

            $expense = Expense::with('account')->find($expense->id);

            return response()->json(["success"=>true, 'status'=>'created', 'expense'=>$expense]);
        } else { 
            $expense = Expense::find($request->expense['id']);   
            if(!$expense) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        
         
            // update
            // amount and account will not update
            $expense->update([
                'title' => $request->expense['title'],
                'expense_date' => $request->expense['expense_date'],
                'reason' => $request->expense['reason'],
                'type' => $request->expense['type'],
            ]);
            $expense = Expense::with('account')->find($expense->id);

            return response()->json(["success"=>true, 'status'=>'updated', 'expense'=>$expense]);
        }
    }
}
