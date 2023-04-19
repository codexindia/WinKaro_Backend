<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserAllNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\AppPopupMessage;
use Illuminate\Support\Facades\Storage;
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
        $old = AppPopupMessage::latest()->first();
        return view('admin.notification', compact('old'));
    }
    public function push_popup(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            'action_url' => 'required',

        ]);

        if ($request->hasFile('image')) {
            $image_path = Storage::put('public/users/popup_images', $request->file('image'));
        } else {
            $image_path = null;
        }

        if ($request->has('active')) {
            $status = 1;
        } else {
            $status = 0;
        }
        AppPopupMessage::updateOrCreate(
            ['id' => 1],
            ['status' => $status, 'image_src' => null, 'image_src' => $image_path, 'description' => $request->description, 'action_url' => $request->action_url]
        );
        return back()->with(['success_popup' => 'Popup Message Update SuccessFully']);
    }
}
