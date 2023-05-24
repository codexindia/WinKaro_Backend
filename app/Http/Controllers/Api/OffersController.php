<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompleteOffers;
use App\Models\CompleteTask;
use App\Models\OfferSubmissions;

class OffersController extends Controller
{
  private function claimed_offer($user_id, $task_name, $reward_coins, $status = 'processing', $inputs = null)
  {

    $new = new CompleteOffers;
    $new->user_id = $user_id;
    $new->name = $task_name;
    $new->reward_coins = $reward_coins;
    $new->status = $status;
    $new->attributes = $inputs;
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
        $result = (new WalletManage)->AddPayment($user_id, 1000, 'YT Task Milestone', 'reward');
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
  }
  public function telegram_task(Request $request)
  {
    $request->validate([
      'telegram_username' => 'required',
    ]);
    if (CompleteOffers::where([
     'user_id' => $request->user()->id,
     'name' => 'telegram_task',
    ])->exists()) {
      return response()->json([
        'status' => false,
        'message' => 'Offer Already Claimed',
      ]);
    }

    if (CompleteOffers::whereJsonContains('attributes', ['username' => $request->telegram_username])->exists()) {
      return response()->json([
        'status' => false,
        'message' => 'Offer Already Claimed With This Username',
      ]);
    }
    $user_id = $request->user()->id;
    $input = json_encode([
      'username' => $request->telegram_username,
    ]);
    $this->claimed_offer($user_id, 'telegram_task', 100, 'processing', $input);
    return response()->json([
      'status' => true,
      'message' => 'Offer Is Processing, Wait For Approval',
    ]);
  }
  public function app_install_task(Request $request)
  {
    $request->validate([
      'telegram_username' => 'required',
    ]);
  }
}
