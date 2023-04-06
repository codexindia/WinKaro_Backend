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
        $check = GameLimit::whereDate(
            'created_at', Carbon::today(),
        )->where([
                'user_id' => $user_id,
                'type' => 'watch_and_earn',
            ]);
        if ($check->count() >= 10) {
            return response()->json([
                'status' => false,
                'message' => 'Todays Limit Exceeds'
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
        $check = GameLimit::whereDate(
            'created_at', Carbon::today(),
        )->where([
                'user_id' => $user_id,
                'type' => 'watch_and_earn',
            ]);
        if ($check->count() >= 10) {
            return response()->json([
                'status' => false,
                'message' => 'Todays Limit Exceeds'
            ]);
        }
        GameLimit::create([
            'user_id' => $user_id,
            'type' => 'watch_and_earn',
        ]);
        $amount = 5;
        $description = 'Reward Added For Watch And Earn Program';
        $status = 'added';
        $result = (new WalletManage)->AddLog($user_id,$amount,$description,$status);
       return response()->json([
        'status' => true,
        'amount' => $amount
        'message' => 'Reward Has Been Added In Your Wallet'
       ]);
    }
}