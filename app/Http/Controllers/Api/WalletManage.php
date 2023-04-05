<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WalletBinds;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\User;
class WalletManage extends Controller
{
    public function AddLog($user_id,$amount,$description,$status)
    {
        $new = new WalletTransaction;
        $new->user_id = $user_id;
        $new->amount = $amount;
        $new->description = $description;
        $new->status = $status;
        $new->ref_id = 'WNKR'.rand(1000000,9999999);
        if($new->save())
        {
            User::find($user_id)->increment('balance',$amount);
        }
        
    }
    public function bind_ac(Request $request)
    {
        $request->validate([
         'type' => 'required|in:paytm,upi',
         'account_number' => 'required',
        ]);
       $user_id = $request->user()->id;
        if(WalletBinds::where('user_id',$user_id)->exists())
        {
            return response()->json([
                'status' => false,
                'message' => 'User Already Bind There Account',
            ]);
        }else
        {
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
        $user_id = $request->user()->id;
        $data = WalletBinds::where('user_id',$user_id)->get();
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'User Account Retrieve SuccessFully',
        ]);
    }

    public function get_transactions(Request $request)
    {
        $userid = $request->user()->id;
       $data = WalletTransaction::where('user_id',$userid)->orderBy('id','desc')->get();
       return response()->json([
           'status' => true,
           'data' => $data,
           'message' => 'Transaction Log Retrieve SuccessFully',
       ]);
    }

}
