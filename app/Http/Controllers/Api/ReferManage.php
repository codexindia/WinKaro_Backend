<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferHistory;
class ReferManage extends Controller
{
    public function get_history(Request $request)
    {
    $main = ReferHistory::where('refer_by_user_id',$request->user()->id)->get();
    $main->makeHidden('updated_at','created_at','refer_by_user_id');
    $data = [];
   
   foreach($main as $item)
   {
    
    $item->GetName->makeHidden('updated_at','created_at','phone','email','balance','refer_code','referred_by');
    $data = $item;
   }
    return response()->json([
        'status' => true,
        'data' => $data,
        'message' => 'Refer History Fetched SuccessFully',
    ]);
    }
}
