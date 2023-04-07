<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllTasks;
class TaskManage extends Controller
{
   public function get_tasks(Request $request)
   {
    $user = $request->user();
    $type = $request->type;
    $data = AllTasks::where('type', $type)->get();
    return response()->json([
        'status' => true,
        'data' => $data,
        'message' => 'Youtube Task Retrieve SuccessFully',
    ]);
   }
}
