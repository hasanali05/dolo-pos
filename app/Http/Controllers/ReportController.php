<?php

namespace App\Http\Controllers;
use App\Account;
use App\Purchase;
use App\Supplier;
use App\Customer;
use App\PurchaseTransaction;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function redeem()
    {
        return view('admin.report.redeem');
    }
    public function redeemsAll()
    {
        $redeems = PurchaseTransaction::with('supplier')
                        ->where('redeem_date','>=', today())
                        ->get();
        return response()->json(["redeems"=>$redeems]);
    }
    public function redeemsRedeemed(Request $request)
    {
        $redeem = PurchaseTransaction::find($request->redeem_id);
        if($redeem) {
            $redeem->redeem_status = 'redeemed';
            $redeem->save();
            return response()->json(["success"=>true]);
        } else {
            return response()->json(["success"=>false]);
        }
    }
    public function overview()
    {
        return view('admin.report.overview');
    }
    public function overviewGet(Request $request)
    {
        if($request->ajax()) {
            $purchases = [];
            $sales = [];
            $accounts = [];
            $inventory = [];
            $expense = [];
            $profitLoss = [];

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $to_date = str_replace('-', '/', $to_date);
            $to_date = date('Y-m-d',strtotime($to_date . "+1 days"));

            $suppliers = Supplier::with('account')->select('account_id')->groupBy('account_id')->get();
            $limit = count($suppliers);
            $suppliers_sum = 0;
            for ($i=0; $i < $limit; $i++) {
                $sum = $suppliers[$i]->account->ledgers
                        ->where('entry_date','>=', $from_date)
                        ->where('entry_date','<', $to_date)
                        ->sum('credit');
                $suppliers_sum += $sum;
            }

            $customers = Customer::with('account')->select('account_id')->groupBy('account_id')->get();
            $limit = count($customers);
            $customers_sum = 0;
            for ($i=0; $i < $limit; $i++) {
                $sum = $customers[$i]->account->ledgers
                        ->where('entry_date','>=', $from_date)
                        ->where('entry_date','<', $to_date)
                        ->sum('debit');
                $customers_sum += $sum;
            }

            $inventoryAccount = Account::where('name', '=', 'Inventory')
                ->where('group', '=', 'Capital')
                ->where('sub_group', '=', 'Capital')
                ->first();
            if($inventoryAccount){
                $inventory_sum = $inventoryAccount->ledgers
                    ->where('entry_date','>=', $from_date)
                    ->where('entry_date','<', $to_date)
                    ->sum('balance');
            } else {
                $inventory_sum = 0; 
            }

            $expenseAccount = Account::where('name', '=', 'Shop expense')
                ->where('group', '=', 'Expense')
                ->where('sub_group', '=', 'Expense')
                ->first();
            if($expenseAccount){
                $expense_sum = $expenseAccount->ledgers
                    ->where('entry_date','>=', $from_date)
                    ->where('entry_date','<', $to_date)
                    ->sum('balance');
            } else {
                $expense_sum = 0;
            }
            
            $profitLossAccount = Account::where('name', '=', 'Profit & Loss')
                ->where('group', '=', 'Capital')
                ->where('sub_group', '=', 'Profit & Loss')
                ->first();
            if($profitLossAccount){
                $profit_loss_sum = $profitLossAccount->ledgers
                    ->where('entry_date','>=', $from_date)
                    ->where('entry_date','<', $to_date)
                    ->sum('balance');
            } else {
                $profit_loss_sum = 0;
            }

            return response()->json([
                'purchases'=>$suppliers_sum,
                'sales'=>$customers_sum,
                'inventory'=>$inventory_sum,
                'expenses'=>$expense_sum,
                'profitLoss'=>$profit_loss_sum,
            ]);
        }
        return back()->with('info', 'Unauthorised access.');
    }
    public function incomeExpense()
    {
        return view('admin.report.incomeExpense');
    }
    public function incomeExpenseGet(Request $request)
    {
        if($request->ajax()) {
            $incomes = [];
            $expenses = [];

            $income_accounts = Account::where('group', 'Income')->get();
            $expenses_accounts = Account::where('group', 'Expense')->get();
            $incomes = [];
            $expenses = [];
            $limit = count($income_accounts);

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $to_date = str_replace('-', '/', $to_date);
            $to_date = date('Y-m-d',strtotime($to_date . "+1 days"));

            for ($i=0; $i < $limit; $i++) {
                $sum = $income_accounts[$i]->ledgers
                        ->where('ledgers.created_at','>=', $from_date)
                        ->where('ledgers.created_at','<', $to_date)
                        ->sum('balance');
                if($sum > 0) {
                    $income_accounts[$i]['amount']=$sum;
                    array_push($incomes, $income_accounts[$i]);
                }
            }
            $limit = count($expenses_accounts);
            for ($i=0; $i < $limit; $i++) {
                $sum = $expenses_accounts[$i]->ledgers
                        ->where('created_at','>=', $from_date)
                        ->where('created_at','<', $to_date)
                        ->sum('balance');
                if($sum > 0) {
                    $expenses_accounts[$i]['amount']=$sum;
                    array_push($incomes, $expenses_accounts[$i]);
                }
            }
            return response()->json([
                'incomes'=>$incomes,
                'expenses'=>$expenses,
            ]);
        }
        return back()->with('info', 'Unauthorised access.');
    }
    public function inventoryReport()
    {
        return view('admin.report.inventoryReport');
    }
    public function LedgerReport()
    {
        return view('admin.report.ledger');
    }

    public function purchaseReport()
    {
        $purchaseReportLists = Purchase::all();
        return view('admin.report.purchase')->with(compact('purchaseReportLists'));
    }
    public function saleReport()
    {
        return view('admin.report.sale');
    }
    public function supplierReport()
    {
        return view('admin.report.supplier');
    }
    public function customerReport()
    {
        return view('admin.report.customer');
    }
    public function dueReceive()
    {
        return view('admin.report.dueReceive');
    }
    public function duePaySummery()
    {
        return view('admin.report.duePay');
    }
}
