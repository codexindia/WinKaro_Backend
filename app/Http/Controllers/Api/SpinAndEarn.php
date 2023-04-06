<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WalletManage;
use App\Models\GameLimit;
class SpinAndEarn extends Controller
{
    public function add_reward(Request $request)
    {
        $request->validate([
        'coin' => 'required|in:6,7,8,9,10',
        ]);
        $user_id = $request->user()->id;
        $check = GameLimit::whereDate(
          'created_at', Carbon::today(),
         )->where([
           'user_id' => $user_id,
           'type' => 'spin_and_earn',
       ]);
       if($check->count() >= 10)
       {
        return response()->json([
          'status' => false,
          'message' => 'Todays Limit Exceeds'
        ]);
      }
       
        GameLimit::create([
          'user_id' => $user_id,
          'type' => 'spin_and_earn',
         ]);
        $user_id = $request->user()->id;
        $amount = $request->coin;
        $description = 'Wining Through Spin And Earn';
        $status = 'added';
        $result = (new WalletManage)->AddLog($user_id,$amount,$description,$status);
        return response()->json([
          'status' => true,
          'message' => 'Reward Has Been Added',
        ]);
    }
    public function get_spin_coin(Request $request)
    {
      $user_id = $request->user()->id;
      $check = GameLimit::whereDate(
       'created_at', Carbon::today(),
      )->where([
        'user_id' => $user_id,
        'type' => 'spin_and_earn',
    ]);
      if($check->count() >= 10)
      {
        return response()->json([
          'status' => false,
          'message' => 'Todays Limit Exceeds'
        ]);
      }
     $coin = rand(6,10);
    
     return response()->json([
        'status' => true,
        'data' => $coin,
        'message' => 'Spin Coin Retrieve SuccessFully',
     ]);
    }
}
