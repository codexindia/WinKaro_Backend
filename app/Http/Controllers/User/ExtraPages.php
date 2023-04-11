<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtraPages extends Controller
{
   public function privacy_policy()
   {
    return view('users.privacy');
   }
   public function terms_and_conditions()
   {
    return view('users.terms_and_condition');
   }
}
