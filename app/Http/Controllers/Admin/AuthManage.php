<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthManage extends Controller
{
   public function index(Request $request)
   {
    return view('admin.login');
   }
   public function login_attempt(Request $request)
   {
   $request->validate([
   'first_name' => 'required|min:6',
   ]);
   }
}
