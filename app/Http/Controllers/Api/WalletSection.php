<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WalletBinds;
class WalletSection extends Controller
{
    
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
}
