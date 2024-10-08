<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtraPages extends Controller
{
   public function privacy_policy()
   {
      return redirect('https://docs.google.com/document/d/1J_qBhaQ0pBEfulEjlwtS_NiBUrrG_rZh0My_Sa0if4Y');
    //return view('users.privacy');
   }
   public function terms_and_conditions()
   {
      return redirect('https://docs.google.com/document/d/1J_qBhaQ0pBEfulEjlwtS_NiBUrrG_rZh0My_Sa0if4Y');
  
   }
}
