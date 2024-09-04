<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthManager extends Controller
{
   public function loginPage(){
       return view('manager.auth.login');
   }
   public function loginPageSubmit(Request $request){
       $request->validate([
           'phone_number' => 'required|numeric|digits:10|exists:area_managers,phoneNumber',
           'password' => 'required|min:6'
       ]);
      
       if (Auth::guard('manager')->attempt([
              'phoneNumber' => $request->phone_number,
              'password' => $request->password
       ])) {
           return redirect()->route('manager.dashboard');
       }
       return back()->withErrors([
           'phone_number' => 'The provided credentials do not match our records.',
       ]);
   }
}
