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
      'coin' => 'required|numeric|lte:50',
    ]);
    $user_id = $request->user()->id;
    $check = GameLimit::where([
      'user_id' => $user_id,
      'type' => 'spin_and_earn',
    ])->latest()->first();
    $now = Carbon::now();
    if ($check && $now->isAfter($check->expire_at) != 1) {
      return response()->json([
        'status' => false,
        'message' => 'Limit Exceeds Try After ' . $now->diffInMinutes($check->expire_at).' Minutes'
      ]);
    }

    GameLimit::create([
      'user_id' => $user_id,
      'type' => 'spin_and_earn',
      'expire_at' => Carbon::now()->addMinute(30)
    ]);
    $user_id = $request->user()->id;
    $amount = $request->coin;
    $description = 'Wining Through Spin And Earn';

    $result = (new WalletManage)->AddPayment($user_id, $amount, $description, 'reward');
    return response()->json([
      'status' => true,
      'message' => 'Reward Has Been Added',
    ]);
  }
  public function get_spin_coin(Request $request)
  {
    $user_id = $request->user()->id;

    $check = GameLimit::where([
      'user_id' => $user_id,
      'type' => 'spin_and_earn',
    ])->latest()->first();
    $now = Carbon::now();
    if ($check && $now->isAfter($check->expire_at) != 1) {
      return response()->json([
        'status' => false,
        'message' => 'Limit Exceeds Try After ' . $now->diffInMinutes($check->expire_at).' Minutes'
      ]);
    }

    GameLimit::create([
      'user_id' => $user_id,
      'type' => 'spin_and_earn',
      'expire_at' => Carbon::now()->addMinute(30)
    ]);

    $coins = array(6, 7, 8, 9, 10, 20, 30, 50);
    $coins = $coins[rand(0, 7)];
    return response()->json([
      'status' => true,
      'data' => $coins,
      'message' => 'Spin Coin Retrieve SuccessFully',
    ]);
  }
}
