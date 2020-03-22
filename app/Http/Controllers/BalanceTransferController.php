<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BalanceTransfer;
use App\Ledger;
use Auth;

class BalanceTransferController extends Controller
{
	public function balanceTransfers()
	{
		return view('admin.balanceTransfers.index');
	}
    public function balanceTransfersAll()
    {
        $balanceTransfers = BalanceTransfer::all();
        return response()->json(["balanceTransfers"=>$balanceTransfers]);
    }
    public function addOrUpdate(Request $request) 
    {
        //validate data
        $validator = \Validator::make($request->balanceTransfer, [
            'from_account_id'=>'required|numeric|exists:accounts,id',
            'to_account_id'=>'required|numeric|exists:accounts,id',
            'amount'=>'required|numeric|min:1',
            'note'=>'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        if($request->balanceTransfer['id'] == null){
            // create
            $balanceTransfer = BalanceTransfer::create([
                'from_account_id' => $request->balanceTransfer['from_account_id'],
                'to_account_id' => $request->balanceTransfer['to_account_id'],
                'amount' => $request->balanceTransfer['amount'],
                'note' => $request->balanceTransfer['note'],
            ]);

            $transfer = new Ledger;
            $transfer->entry_date = today();
            $transfer->account_id = $request->balanceTransfer['from_account_id'];
            $transfer->detail = $balanceTransfer->id;
            $transfer->type = 'balanceTransfer';

            $transfer->debit = 0;
            $transfer->credit = $request->balanceTransfer['amount'];
            $transfer->balance = (-1)*($request->balanceTransfer['amount']);

            $transfer->created_by = Auth::user()->id;
            $transfer->modified_by = Auth::user()->id;
            $transfer->save();
            
            $transfer = new Ledger;
            $transfer->entry_date = today();
            $transfer->account_id = $request->balanceTransfer['to_account_id'];
            $transfer->detail = $balanceTransfer->id;
            $transfer->type = 'balanceTransfer';

            $transfer->debit = $request->balanceTransfer['amount'];
            $transfer->credit = 0;
            $transfer->balance = $request->balanceTransfer['amount'];

            $transfer->created_by = Auth::user()->id;
            $transfer->modified_by = Auth::user()->id;
            $transfer->save();

            $balanceTransfer = BalanceTransfer::find($balanceTransfer->id);
            return response()->json(["success"=>true, 'status'=>'created', 'balanceTransfer'=>$balanceTransfer]);
        } else { 
            $balanceTransfer = BalanceTransfer::find($request->balanceTransfer['id']);   
            if(!$balanceTransfer) return response()->json(["success"=>true, 'status'=>'somethingwrong']);        

            //update
            $balanceTransfer->update([
                'note' => $request->balanceTransfer['note'],
            ]);
            return response()->json(["success"=>true, 'status'=>'updated', 'balanceTransfer'=>$balanceTransfer]);
        }
    }
}
