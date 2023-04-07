<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllTasks;

class TaskManage extends Controller
{
   public function index()
   {
      $data = AllTasks::orderBy('id','desc')->get();
      $view = "list";
      return view('admin.tasks', compact('view','data'));
   }
   public function new()
   {
      $view = "add";
     
      return view('admin.tasks', compact('view'));
   }
   public function create(Request $request)
   {
      $request->validate([

         'title' => 'required',
         'publisher' => 'required',
         'action_url' => 'required|url',
         'reward_coin' => 'required|numeric',
         'expire_after_hour' => 'required|numeric',
         'task_type' => 'required|in:youtube,instagram,yt_shorts'
      ]);
      if ($request->task_type == 'youtube') {
         $count = AllTasks::where('type', 'youtube')->count();
         $task_name = 'Youtube Task ' . $count;
      } elseif ($request->task_type == 'instagram') {
         $count = AllTasks::where('type', 'instagram')->count();
         $task_name = 'Instagram Task ' . $count;
      }
      elseif ($request->task_type == 'yt_shorts') {
         $count = AllTasks::where('type', 'yt_shorts')->count();
         $task_name = 'Shorts Task ' . $count;
      }
      AllTasks::create([
         'task_name' =>  $task_name,
         'type' => $request->task_type,
         'title' => $request->title,
         'publisher' => $request->publisher,
         'reward_coin' => $request->reward_coin,
         'expire_at' => Carbon::now()->addHour($request->expire_after_hour),
         'status' => 'active',
         'thumbnail_image' => 'demo',
         'action_url' => $request->action_url,
      ]);
      return back()->with(['success' => 'Task Created SuccessFully']);
   }
}