<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\WalletManage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawRequest;

class WithdrawManage extends Controller
{
    public function index()
    {
        $get = WithdrawRequest::where('status', 'processing')->orderBy('id', 'desc')->get();
        $view = 'List';
        return view('admin.withdraw', compact('view', 'get'));
    }
    public function action(Request $request)
    {
        if ($request->Action == 'Reject') {
            $main = WithdrawRequest::where('id',$request->id);
            $main->update([
               'status' => 'failed',
            ]);
            $main = $main->first();
            $user_id = $main->user_id;
            $amount = $main->coins;
            $description = 'Refund For Rejected Requests If WWithdraws';
            $status = 'credit';
            $result = (new WalletManage)->AddPayment($user_id, $amount, $description, $status, 'reward');
            return back()->with(['success' => 'Request Rejected Successfully']);
        } elseif ($request->Action == 'Approve') {
            WithdrawRequest::where('id',$request->id)->update([
                'status' => 'success',
             ]);
             return back()->with(['success' => 'Request Approved Successfully']);
        }
    }
}
