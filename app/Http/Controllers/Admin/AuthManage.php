<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllTasks;
use App\Notifications\UserAllNotifications;
use Carbon\Carbon;
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
        if (Auth::guard('admin')->attempt(['username' => $request->user_name, 'password' => $request->password],$request->remember)) {
         $request->session()->regenerate();
         return redirect(route('dashboard'));
     }
     return back()->withErrors(['msg' => 'Opps! You have entered invalid credentials']);
   }








   public function test()
   {
     
   //    $users = User::all();
   //    $param['title'] = "demo2";
   //    $param['subtitle'] = "demo2";
   //  Notification::send($users, new UserAllNotifications($param));
   }
}