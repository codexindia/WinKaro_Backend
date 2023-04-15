<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserAllNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationManage extends Controller
{
    public function push_alert(Request $request)
   {
    $request->validate([
        'title' => 'required',
        'message' => 'required',
    ]);
     
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
}
