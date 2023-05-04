<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\CompleteTask;
use App\Models\ReferHistory;

class ProfileController extends Controller
{
   public function getuser(Request $request)
   {
      $user = User::find($request->user()->id);
      $data['complete_tasks'] = CompleteTask::where([
         'status' => 'complete',
         'user_id'  => $request->user()->id,
      ])->count();
      $refer_data['pending'] = ReferHistory::where([
         'refer_by_user_id' => $request->user()->id,
         'status' => 'pending'
      ])->count();
      $refer_data['success'] = ReferHistory::where([
         'refer_by_user_id' => $request->user()->id,
         'status' => 'success'
      ])->count();
      $total_refer_counts = [
         'pending' => $refer_data['pending'],
         'success' => $refer_data['success'],
      ];
      $data['alert_count'] = $user->unreadNotifications->count();
      return response()->json([
         'status' => true,
         'refer_counts' => $total_refer_counts,
         'complete_tasks' => $data['complete_tasks'],
         'unread_alert' => $data['alert_count'],
         'data' => $request->user(),
         'message' => 'user retrieve successfully',
      ]);
   }
   public function update_profile(Request $request)
   {
      $request->validate([
         'profile_pic' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
         'name' => 'required',
         'email' => 'email|required',
      ]);

      $main = User::find($request->user()->id);
      if ($request->hasFile('profile_pic')) {
         $image_path = Storage::put('public/users/profiles', $request->file('profile_pic'));
         $main->update([
            'profile_pic' => $image_path,
         ]);
      }
      $main->update([
         'email' => $request->email,
         'name' => $request->name,

      ]);
      return response()->json([
         'status' => true,
         'message' => 'Updated SuccessFully',
      ]);
   }
}
