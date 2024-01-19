<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameLimit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WalletManage;
class WatchAndEarn extends Controller
{
    public function get_reward_video(Request $request)
    {
        $user_id = $request->user()->id;
        $check = GameLimit::where([
            'user_id' => $user_id,
            'type' => 'watch_and_earn',
          ])->latest()->first();
          $now = Carbon::now();
          if ($check && $now->isAfter($check->expire_at) != 1) {
            return response()->json([
              'status' => false,
              'message' => 'Limit Exceeds Try After ' . $now->diffInMinutes($check->expire_at).' Minutes'
            ]);
          }
       
        return response()->json([
            'status' => true,
            'message' => 'Reward Videos Available',
        ]);
    }
    public function add_reward(Request $request)
    {
        $user_id = $request->user()->id;
        $check = GameLimit::where([
            'user_id' => $user_id,
            'type' => 'watch_and_earn',
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
            'type' => 'watch_and_earn',
        ]);
        $amount = 5;
        $description = 'Reward Added For Watch And Earn Program';
       
        $result = (new WalletManage)->AddPayment($user_id,$amount,$description,'reward');
       return response()->json([
        'status' => true,
        'amount' => $amount,
        'message' => 'Reward Has Been Added In Your Wallet'
       ]);
    }
}