<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WalletBinds;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\User;
use App\Models\WithdrawRequest;

class WalletManage extends Controller
{
    public function AddPayment($user_id, $amount, $description, $status, $type)
    {
        $new = new WalletTransaction;
        $new->user_id = $user_id;
        $new->amount = $amount;
        $new->description = $description;
        $new->status = $status;
        $new->type = $type;
        $new->ref_id = 'WNKR' . rand(1000000, 9999999);
        if ($new->save()) {
            User::find($user_id)->increment('balance', $amount);
        }

    }
    public function CutPayment($user_id, $amount, $description, $status, $type)
    {
        $new = new WalletTransaction;
        $new->user_id = $user_id;
        $new->amount = $amount;
        $new->description = $description;
        $new->status = $status;
        $new->type = $type;
        $new->ref_id = 'WNKR' . rand(1000000, 9999999);
        if ($new->save()) {
            User::find($user_id)->decrement('balance', $amount);
        }

    }

    public function bind_ac(Request $request)
    {
        $request->validate([
            'type' => 'required|in:paytm,upi',
            'account_number' => 'required',
        ]);
        $user_id = $request->user()->id;
        if (WalletBinds::where('user_id', $user_id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User Already Bind There Account',
            ]);
        } else {
            $new = new WalletBinds;
            $new->user_id = $user_id;
            $new->type = $request->type;
            $new->account_number = $request->account_number;
            $new->save();
            return response()->json([
                'status' => true,
                'message' => 'User Account Bind SuccessFully',
            ]);
        }
    }
    public function get_account(Request $request)
    {
        $user = $request->user();
        $data = WalletBinds::where('user_id', $user->id)->get();
        return response()->json([
            'status' => true,
            'coins' => $user->balance,
            'coin_to_inr' => $user->balance / 100,
            'data' => $data,
            'message' => 'User Account Retrieve SuccessFully',
        ]);
    }

    public function get_transactions(Request $request)
    {
        $type = $request->type;
        $userid = $request->user()->id;
        if ($request->type == 'withdraw') {

            $data = WithdrawRequest::where(['user_id' => $userid])->orderBy('id', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => 'Transaction Log Retrieve SuccessFully',
            ]);
        } else {
            $data = WalletTransaction::where(['user_id' => $userid])->orderBy('id', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => 'Transaction Log Retrieve SuccessFully',
            ]);
        }
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'coin' => 'required|numeric',
        ]);
        $user = $request->user();
        if (2500 > $request->coin) {
            return response()->json([
                'status' => false,
                'message' => 'Amount Can Withdraw Minimum 2500 Coins'
            ]);
        }
        if ($user->balance >= $request->coin) {
            $walletdata = WalletBinds::where('user_id', $user->id)->first();

            $this->CutPayment($user->id, $request->coin, 'Payment Withdraw Request', 'debit', 'withdraw');
            $account = json_encode([
                'type' => $walletdata->type,
                'account_number' => $walletdata->account_number
            ]);
            WithdrawRequest::create([
                'user_id' => $user->id,
                'coins' => $request->coin,
                'status' => 'processing',
                'ref_id' => 'WINCASH' . rand(100000, 999999),
                'account_data' => $account,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Withdraw Requested SuccessFully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You Need More ' . $request->coin - $user->balance . ' Coins To Withdraw',
            ]);
        }
    }

}