<?php

namespace App\Http\Controllers;
use App\Account;
use App\Purchase;

use Illuminate\Http\Request;

class ReportController extends Controller
{
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
