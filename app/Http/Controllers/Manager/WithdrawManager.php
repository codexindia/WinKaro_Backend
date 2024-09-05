<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaManager;
use App\Models\ManagerWithdrawals;
class WithdrawManager extends Controller
{
    public function index()
    {
        $data['availableBalance'] = auth('manager')->user()->availableBalance;
        $data['withdrawals'] = ManagerWithdrawals::where('mid', auth('manager')->user()->id)->orderBy('id', 'desc')->get();
        return view('manager.withdraw', $data);
    }
    public function submitWithdraw(Request $request)
    {
        $request->validate([
            'coins' => 'required|numeric|min:1|max:' . auth('manager')->user()->availableBalance,
            'upi_id' => 'required'
        ]);
        $user = AreaManager::find(auth('manager')->user()->id);
        $user->availableBalance -= $request->coins;
        $user->save();
        $newWithdraw = new ManagerWithdrawals();
        $newWithdraw->mid = auth('manager')->user()->id;
        $newWithdraw->coins = $request->coins;
        $newWithdraw->upiId = $request->upi_id;
    //    $newWithdraw->valuation = $request->coins * 0.01;
       // $newWithdraw->status = 'pending';

        $newWithdraw->transaction_id = 'TRX' . time();
        $newWithdraw->save();
        return back()->with(['success' => 'Withdraw request submitted successfully']);
    }
   
}
