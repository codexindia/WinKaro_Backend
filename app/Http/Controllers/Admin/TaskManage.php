<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllTasks;
use Illuminate\Support\Facades\Storage;
use App\Models\CompleteTask;
use App\Http\Controllers\Api\WalletManage;

class TaskManage extends Controller
{
   public function index()
   {
      $data = AllTasks::orderBy('id', 'desc')->get();
      $view = "list";
      return view('admin.tasks', compact('view', 'data'));
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
         'task_type' => 'required|in:youtube,instagram,yt_shorts',
         'thumbnail' => 'required|image',
      ]);
      if ($request->task_type == 'youtube') {
         $count = AllTasks::where('type', 'youtube')->count();
         $task_name = 'Youtube Task ' . $count;
      } elseif ($request->task_type == 'instagram') {
         $count = AllTasks::where('type', 'instagram')->count();
         $task_name = 'Instagram Task ' . $count;
      } elseif ($request->task_type == 'yt_shorts') {
         $count = AllTasks::where('type', 'yt_shorts')->count();
         $task_name = 'Shorts Task ' . $count;
      }
      $thumbnail_path = Storage::put('public/tasks/thumbnails', $request->file('thumbnail'));
      AllTasks::create([
         'task_name' =>  $task_name,
         'type' => $request->task_type,
         'title' => $request->title,
         'publisher' => $request->publisher,
         'reward_coin' => $request->reward_coin,
         'expire_at' => Carbon::now()->addHour($request->expire_after_hour),
         'status' => 'active',
         'thumbnail_image' => $thumbnail_path,
         'action_url' => $request->action_url,
      ]);
      return back()->with(['success' => 'Task Created SuccessFully']);
   }
   public function submission_list(Request $request)
   {
      $getmain = CompleteTask::where('status', 'processing')->get();
      $view = "list";
      return view('admin.checksubmissions', compact('view', 'getmain'));
   }
   public function submission_details(Request $request)
   {
      $data = CompleteTask::findOrFail($request->id);
      $view = "details";
      return view('admin.checksubmissions', compact('view', 'data'));
   }
   public function change_status(Request $request)
   {
      if ($request->Action == "Accept") {
         $request->validate([
            'proof_id' => 'required|exists:complete_tasks,id'
         ]);
         $data = CompleteTask::findOrFail($request->proof_id);
         $data->update([
            'status' => 'complete',
         ]);
         $user_id = $data->user_id;
         $amount = $data->reward_coin;
         $description = 'Wining For Complete Task';
         $status = 'credit';
         $result = (new WalletManage)->AddPayment($user_id, $amount, $description, $status, 'reward');
         return response()->json([
            'status' => 'true',
            'message' => 'Task Approved SuccessFully',
         ]);
      } elseif ($request->Action == "Reject") {
         $request->validate([
            'proof_id' => 'required|exists:complete_tasks,id',
            'reason' => 'required',
         ]);
         $data = CompleteTask::findOrFail($request->proof_id);
         $data->update([
            'status' => 'rejected',
         ]);
         return response()->json([
            'status' => 'true',
            'message' => 'Task Reject SuccessFully',
         ]);
      }
   }
}
