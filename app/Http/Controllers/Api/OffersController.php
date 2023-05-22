<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompleteOffers;
use App\Models\CompleteTask;

class OffersController extends Controller
{
  private function claimed_offer($user_id, $task_name, $reward_coins, $status = 'processing')
  {

    $new = new CompleteOffers;
    $new->user_id = $user_id;
    $new->name = $task_name;
    $new->reward_coins = $reward_coins;
    $new->status = $status;

    if ($new->save()) {
      return 1;
    } else {
      return 0;
    }
  }
  public function check_status(Request $request)
  {
    $main = CompleteOffers::where('user_id', $request->user()->id)->get(['name', 'status']);
    return response()->json([
      'status' => true,
      'data' => $main,
      'message' => 'Offers status',
    ]);
  }
  public function yt_task_milestone(Request $request)
  {

    $user_id = $request->user()->id;
    if (CompleteOffers::where([
      'user_id' => $user_id,
      'name' => 'yt_task_milestone',
    ])->exists()) {
      return response()->json([
        'status' => false,
        'message' => 'Offer Already Claimed',
      ]);
    }
    $get_completed_task  = CompleteTask::where([
      'user_id' => $user_id,
      'status' => 'complete',
    ])->get('type');
    $status = 1;
    //return $get_completed_task;
    foreach ($get_completed_task as $item) {
      if ($item->type == 'youtube') {
        $status += 1;
      } else {
        $status = 0;
      }
      if ($status == 10) {
        $this->claimed_offer($user_id, 'yt_task_milestone', 1000, 'complete');
        $result = (new WalletManage)->AddPayment($user_id, 1000, 'YT Task Milestone','reward');
        return response()->json([
          'status' => true,
          'reward_coins' => 1000,
          'message' => 'Offer Claimed Successfully',
        ]);
      }
    }
    return response()->json([

      'status' => false,
      'message' => 'Offer Not FullFiled',
    ]);
    // $this->claimed_offer($user_id, 'yt_task_milestone', 500, 'complete');


  }
}
