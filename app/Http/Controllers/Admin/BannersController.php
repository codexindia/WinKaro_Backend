<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banners;
use Illuminate\Support\Facades\Storage;
class BannersController extends Controller
{
    public function index(Request $request)
    {
        $getall = Banners::all();
        return view('admin.banners',compact('getall'));
    }
    public function upload(Request $request)
   {

      $image_path = Storage::put('public/users/banners', $request->file('banner'));
      Banners::create([
      'name' => $request->name,
      'action_link' => $request->action,
      'source_link' => $image_path,
      ]);
      return back()->with('success','Banner Uploaded SuccessFully');
   }
   public function delete(Request $request)
   {
      Banners::find($request->id)->delete();
      return back()->with('success','Banner Deleted SuccessFully');
   }
}
