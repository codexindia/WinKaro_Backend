<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\UserAllNotifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllTasks;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\CompleteTask;
use App\Http\Controllers\Api\WalletManage;
use App\Models\User;
use App\Models\Question;

class TaskManage extends Controller
{
   public function task_delete(Request $request)
   {
      //    $request->validate([
      //  'task_id' => 'required|exists:all_tasks,id',
      //    ]);
      CompleteTask::where('task_id', $request->task_id)->delete();
      AllTasks::find($request->task_id)->delete();
      return back()->with(['success' => 'Task Deleted Success']);
   }
   public function index()
   {
      $data = AllTasks::orderBy('id', 'desc')->paginate(10);
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
         'task_type' => 'required|in:youtube,instagram,website_check_in',
         'thumbnail' => 'required|image',
      ]);
      $count = 1;
      if ($request->task_type == 'youtube') {
         $find = AllTasks::where('type', 'youtube')->latest()->first();
         if ($find != null) {
            $count = (int)filter_var($find->task_name, FILTER_SANITIZE_NUMBER_INT) + 1;
         }
         $task_name = 'Youtube Task ' . $count;
      } elseif ($request->task_type == 'instagram') {
         $find = AllTasks::where('type', 'instagram')->latest()->first();
         if ($find != null) {
            $count = (int)filter_var($find->task_name, FILTER_SANITIZE_NUMBER_INT) + 1;
         }
         $task_name = 'Instagram Task ' . $count;
      } elseif ($request->task_type == 'website_check_in') {
         $find = AllTasks::where('type', 'website_check_in')->latest()->first();
         if ($find != null) {
            $count = (int)filter_var($find->task_name, FILTER_SANITIZE_NUMBER_INT) + 1;
         }
         $task_name = 'Website Check in ' . $count;
      }
      $thumbnail_path = Storage::put('public/tasks/thumbnails', $request->file('thumbnail'));
      $result = AllTasks::create([
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

      for ($i = 1; $i <= 10; $i++) {
         if ($request['question_' . $i] != null) {
            Question::create([
               'task_id' => $result->id,
               'question' => $request['question_' . $i],
               'answer' => $request['answer_' . $i],
               'required' => $request['check_' . $i] == 1 ? 'yes' : 'no',
            ]);
         }
      }

      return back()->with(['success' => 'Task Created SuccessFully']);
   }

   //task edit
   public function task_edit(Request $request)
   {
      $view = "add";
      $main = AllTasks::FindorFail($request->id);

      return view('admin.tasks', compact('view', 'main'));
   }
   public function task_update(Request $request)
   {
      $request->validate([

         'title' => 'required',
         'publisher' => 'required',
         'action_url' => 'required|url',
         'reward_coin' => 'required|numeric',
         'expire_after_hour' => 'required|numeric',
         'task_type' => 'required|in:youtube,instagram,website_check_in',

      ]);

      $get =  AllTasks::find($request->id);
      if ($request->has('thumbnail')) {
         $thumbnail_path = Storage::put('public/tasks/thumbnails', $request->file('thumbnail'));
         $get->update([
            'thumbnail_image' => $thumbnail_path,
         ]);
      }
      $created_at =  $get->created_at;
      $get->update([

         'type' => $request->task_type,
         'title' => $request->title,
         'publisher' => $request->publisher,
         'reward_coin' => $request->reward_coin,
         'expire_at' => Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->addHour($request->expire_after_hour),
         'action_url' => $request->action_url,
      ]);
      return back()->with(['success' => 'Task Update SuccessFully']);
   }
   public function submission_list(Request $request)
   {
      if ($request->q == '')
         $getmain = CompleteTask::where('status', 'complete')->orderBy('id', 'desc')->paginate(10);
      else {
         $task = AllTasks::where([
            'task_name' => $request->q
         ])->first();
         $taskId = 0;
         if ($task != null) {
            $taskId = $task->id;
         }

         $getmain = CompleteTask::where([
            'status' => 'complete',
            'task_id' => $taskId
         ])->orderBy('id', 'desc')->paginate(10);
         $getmain->appends($request->all());
      }
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
         if ($data->status == 'processing') {


            $data->update([
               'status' => 'complete',
            ]);

            //deleting proof
            $src = str_replace(request()->getSchemeAndHttpHost() . '/storage', "public", $data->proof_src);
            Storage::delete($src);
            //deleting
            $user_id = $data->user_id;

            $param['title'] = 'Task Status';
            $param['subtitle'] = 'Congratulations Your Task ' . $data->GetTask->task_name . ' Has Been Approved. And ' . $data->reward_coin . ' Coins Credited Into Your Wallet';
            Notification::send(User::find($user_id), new UserAllNotifications($param));

            $amount = $data->reward_coin;
            $description = 'Wining For Complete Task';

            $result = (new WalletManage)->AddPayment($user_id, $amount, $description, 'reward');
            return response()->json([
               'status' => 'true',
               'message' => 'Task Approved SuccessFully',
            ]);
         } else {
            return response()->json([
               'status' => 'false',
               'message' => 'Task Already Processed',
            ]);
         }
      } elseif ($request->Action == "Reject") {
         $request->validate([
            'proof_id' => 'required|exists:complete_tasks,id',
            'reason' => 'required',
         ]);
         $data = CompleteTask::findOrFail($request->proof_id);
         if ($data->status == 'processing') {
            $src = str_replace(request()->getSchemeAndHttpHost() . '/storage', "public", $data->proof_src);
            Storage::delete($src);
            $user_id = $data->user_id;

            $param['title'] = 'Task Status';
            $param['subtitle'] = 'Opps! Your Task ' . $data->GetTask->task_name . ' Not Approved . Reason ' . $request->reason;
            Notification::send(User::find($user_id), new UserAllNotifications($param));

            $data->update([
               'status' => 'rejected',
               'remarks' => $request->reason,
            ]);
            return response()->json([
               'status' => 'true',
               'message' => 'Task Reject SuccessFully',
            ]);
         } else {
            return response()->json([
               'status' => 'false',
               'message' => 'Task Already Processed',
            ]);
         }
      }
   }
}
