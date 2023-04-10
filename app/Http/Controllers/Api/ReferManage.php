<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferHistory;

class ReferManage extends Controller
{
    public function get_history(Request $request)
    {
        $main = ReferHistory::where('refer_by_user_id', $request->user()->id)->get(['refer_by_user_id', 'referred_user_id', 'status', 'reward_coin', 'created_at']);
        $data = [];

        foreach ($main as $item) {
            //  $item->GetName->makeHidden('updated_at','created_at','phone','email','balance','refer_code','referred_by');
            $item->GetName->makeHidden('updated_at', 'created_at', 'phone', 'email', 'balance', 'refer_code', 'referred_by');

        }
        return response()->json([
            'status' => true,
            'data' => $main,
            'message' => 'Refer History Fetched SuccessFully',
        ]);
    }
}