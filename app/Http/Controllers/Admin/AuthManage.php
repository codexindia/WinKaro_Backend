<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\UserAllNotifications;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
class AuthManage extends Controller
{
   public function index(Request $request)
   {
      return view('admin.login');
   }
   public function login_attempt(Request $request)
   {
      $request->validate([
         'user_name' => 'required|min:3',
         'password' => 'required|min:6',
      ]);
      //  Admin::create([
      //   'name' => 'Winkaro Admin',
      //   'username' => $request->user_name,
      //   'password' => Hash::make($request->password),

      //   ]);
        if (Auth::guard('admin')->attempt(['username' => $request->user_name, 'password' => $request->password],$request->remember_me)) {
         $request->session()->regenerate();
         return redirect(route('dashboard'));
     }
     return back()->withErrors(['msg' => 'Opps! You have entered invalid credentials']);
   }








   public function test()
   {
     
      $users = User::all();
      $param['title'] = "Hello Here Is Demo Title";
      $param['subtitle'] = "is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";
    Notification::send($users, new UserAllNotifications($param));
   }
}