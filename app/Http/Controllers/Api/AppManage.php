<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUpdate;
class AppManage extends Controller
{
   public function get_update(Request $request)
   {
      $get = AppUpdate::latest()->first();
      return response()->json([
         'status' => true,
         'version_code' => $get != null ? $get->version_code : '1.0',
         'app_link' => $get != null ? $get->app_link : '#',
         'message' => 'Update Retrive Successfully',
      ]);
   }
}
