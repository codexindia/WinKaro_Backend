<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password],$request->remember)) {
         $request->session()->regenerate();
         return redirect(route('admin.dashboard'));
     }
     return back()->withErrors(['msg' => 'Opps! You have entered invalid credentials']);
   }
}