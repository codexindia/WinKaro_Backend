<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserAllNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use OneSignal;
class NotificationManage extends Controller
{
    public function push_alert(Request $request)
   {
    $request->validate([
        'title' => 'required',
        'message' => 'required',
    ]);
  
    OneSignal::sendNotificationToAll(
        $request->message, 
        $url = null, 
        $data = null, 
        $buttons = null, 
        $schedule = null,
        $subtitle = $request->title
    );

      $users = User::all();
      $param['title'] = $request->title;
      $param['subtitle'] = $request->message;
    Notification::send($users, new UserAllNotifications($param));
    return back()->with(['success' => 'Notification Pushed SuccessFully']);
   }
    public function index()
    {
        return view('admin.notification');
    }
    public function push_popup(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            'action_url' => 'required',
           
        ]);

    }
}
