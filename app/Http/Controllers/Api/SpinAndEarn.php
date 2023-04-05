<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WalletTransactionLog;
class SpinAndEarn extends Controller
{
    public function add_reward(Request $request)
    {
        $request->validate([
        'coin' => 'required|in:6,7,8,9,10',
        ]);
        $user_id = $request->user()->id;
        $amount = $request->amount;
        $description = 'Wining Through Spin And Earn';
        $status = 'added';
        $result = (new WalletTransactionLog)->AddLog($user_id,$amount,$description,$status);
        return response()->json([
          'status' => true,
          'message' => 'Reward Has Been Added',
        ]);
    }
    public function get_spin_coin(Request $request)
    {
     $coin = rand(1,6);
     return response()->json([
        'status' => true,
        'data' => $coin,
        'message' => 'Spin Coin Retrieve SuccessFully',
     ]);
    }
}
