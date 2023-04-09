<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banners;
class BannersManage extends Controller
{
   public function get_banner(Request $request)
   {
    $data = Banners::orderBy('id','desc')->get();
    return response()->json([
        'status' => true,
        'data' => $data,
        'message' => 'Banners Retrieve SuccessFully',
    ]);
   }
}
