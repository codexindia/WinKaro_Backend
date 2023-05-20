<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllTasks;
use App\Models\CompleteTask;
use Illuminate\Support\Facades\Storage;
use Wester\ChunkUpload\Chunk;
use Wester\ChunkUpload\Validation\Exceptions\ValidationException;

class TaskManage extends Controller
{
    public function get_tasks(Request $request)
    {
        //for task submit
        $user = $request->user();
        $type = $request->type;
        $taskdata = AllTasks::where([
            'type' => $type,
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




    public function submit_task_v2(Request $request)
    {
        // $request->validate([
        //     'task_id' => 'required|numeric|exists:all_tasks,id',

        // ]);

        try {
            $chunk = new Chunk([
                'name' => 'video', // same as    $_FILES['video']
                'chunk_size' => 40000, // must be equal to the value specified on the client side

                // Driver
                'driver' => 'local', // [local, ftp]

                // Local driver details
                'local_driver' => [
                    'path' => public_path('/storage/users/proof/'), // where to upload the final file
                    'tmp_path' => public_path('/storage/users/proof/temp/'), // where to store the temp chunks
                ],

                // File details
                'file_name' => Chunk::RANDOM_FILE_NAME,
                'file_extension' => Chunk::ORIGINAL_FILE_EXTENSION,

                // File validation
                'validation' => ['extension:mp4,avi,3gp'],
            ]);

            $chunk->validate()->store();

            if ($chunk->isLast()) {
                $proof_src = '/public/users/proof/' . $chunk->createFileName();
                $get_task = AllTasks::findOrFail($request->task_id);
                CompleteTask::create([
                    'user_id' => $request->user()->id,
                    'task_id' => $get_task->id,
                    'type' => $get_task->type,
                    'reward_coin' => $get_task->reward_coin,
                    'proof_src' => $proof_src,
                    'status' => 'processing',
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Task Submitted SuccessFully',
                ]);
            } else {
                $chunk->response()->json([
                    'progress' => $chunk->getProgress()
                ]);
            }
        } catch (ValidationException $e) {
            $e->response(422)->json([
                'message' => $e->getMessage(),
                'data' => $e->getErrors(),
            ]);
        }
    }
}
