<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class ProfileController extends Controller
{
   public function getuser(Request $request)
   {
   $user = User::find($request->user()->id);
   $data['alert_count'] = $user->unreadNotifications->count(); 
    return response()->json([
     'status' => true,
     'unread_alert' => $data['alert_count'],
     'data' => $request->user(),
     'message' => 'user retrieve successfully',
    ]);
   }
}
