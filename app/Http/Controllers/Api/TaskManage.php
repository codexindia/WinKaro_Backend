<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllTasks;
use App\Models\CompleteTask;
use Illuminate\Support\Facades\Storage;

class TaskManage extends Controller
{
    public function get_tasks(Request $request)
    {
        //for task submit
        $user = $request->user();
        $type = $request->type;
        $taskdata = AllTasks::where([
            'type'=> $type,
            'status' => 'active'
            ])->orderBy('id', 'desc')->get();
        $data = [];
        $i = 0;
        foreach ($taskdata as $collection) {
            $i++;
            $check = CompleteTask::where([
                'task_id' => $collection->id,
                'user_id' => $request->user()->id,
            ])->latest()->first();
            if ($check != null) {
                
                $data[] = [
                    'data' => $collection,
                    'status' => $check->status,
                    'remarks' => $check->remarks
                ];
            } else {
                $data[] = [
                    'data' => $collection,
                    
                ];
            }

        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Youtube Task Retrieve SuccessFully',
        ]);
    }
    public function submit_task(Request $request)
    {
        $request->validate([
            'task_id' => 'required|numeric|exists:all_tasks,id',
            'proof_src' => 'required'
        ]);
        $proof_src = Storage::put('public/users/proof', $request->file('proof_src'));
        $get_task = AllTasks::find($request->task_id);
        CompleteTask::create([
            'user_id' => $request->user()->id,
            'task_id' => $request->task_id,
            'type' => $get_task->type,
            'reward_coin' => $get_task->reward_coin,
            'proof_src' => $proof_src,
            'status' => 'processing',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Task Submitted SuccessFully',
        ]);
    }
}