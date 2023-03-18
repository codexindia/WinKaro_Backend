<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   public function getuser(Request $request)
   {
    return response()->json([
     'status' => true,
     'data' => $request->user(),
     'message' => 'user retrive successfully',
    ]);
   }
}
