<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppPopupMessage;
class NotificationManage extends Controller
{
    public function get_notification(Request $request)
    {
        $user = User::find($request->user()->id);
       
        $data = [];
       
        foreach ($user->unreadNotifications as $notification) {
         
            $data['notifications'][] =  [
            'id' => $notification->id,
            'title' => $notification->data['title'],
            'subtitle' => $notification->data['subtitle'],
            ];
          
        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Notification Retrieve SuccessFully',
        ]);
    }
    public function mark_read(Request $request){
        
        $user = User::find($request->user()->id);
        $user->unreadNotifications->markAsRead();
     return response()->json([
        'status' => true,
     ]);
    }
    public function get_popup(Request $request)
    {
  $main = AppPopupMessage::latest()->first();
  return response()->json([
    'status' => true,
    'data' => $main,
    'message' => 'Popup Retrieve Successfully',
  ]);
    }
}
