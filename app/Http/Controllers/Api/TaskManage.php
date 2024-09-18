<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AllTasks;
use App\Models\CompleteTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Wester\ChunkUpload\Chunk;
use App\Models\Question;
use Wester\ChunkUpload\Validation\Exceptions\ValidationException;
use App\Models\ManagerCommision;
use App\Models\AreaManager;
use App\Http\Controllers\Api\GeocodingController;
use App\Http\Controllers\Api\WalletManage;

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
        ])->inRandomOrder()->get();
        $data = [];
        $i = 0;

        foreach ($taskdata as $collection) {
            $i++;
            $ques = Question::where('task_id', $collection->id)->get(['id', 'question', 'required']);
            $check = CompleteTask::where([
                'task_id' => $collection->id,
                'user_id' => $request->user()->id,
            ])->latest()->first();

            if ($check != null) {

                $data[] = [
                    'question' => $ques,
                    'data' => $collection,
                    'status' => $check->status,
                    'remarks' => $check->remarks
                ];
            } else {
                $data[] = [
                    'question' => $ques,
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
        $request->validate([
            'task_id' => 'required|numeric|exists:all_tasks,id',

        ]);

        try {
            $chunk = new Chunk([
                'name' => 'video', // same as    $_FILES['video']
                'chunk_size' => 1048577, // must be equal to the value specified on the client side

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
                $proof_src = 'users/proof/' . $chunk->createFileName();
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

    public function submit_task_v3(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:all_tasks,id',
            'long' => 'required',
            'lat' => 'required',
        ]);
        $question = Question::where('task_id', $request->task_id)->where('required', 'yes')->get();
        $i = 1;

        foreach ($question as $item) {
            if ($item->required == "yes") {

                if (strcasecmp($item->answer, $request['answer_' . $i]) == 0) {

                    if ($question->count() == $i) {
                        $get_task = AllTasks::findOrFail($request->task_id);
                        CompleteTask::create([
                            'user_id' => $request->user()->id,
                            'task_id' => $get_task->id,
                            'type' => $get_task->type,
                            'reward_coin' => $get_task->reward_coin,
                            'proof_src' => "v3tasks",
                            'status' => 'complete',
                        ]);
                        $result = (new WalletManage)->AddPayment($request->user()->id, $get_task->reward_coin, "Coin Added For Completing Task " . $get_task->task_name, 'reward');
                        //share the commission with Area Manager
                        $getPin = new GeocodingController;
                        $getPin = $getPin->getPincode($request);
                        if ($getPin && AreaManager::where('assignedPincode', $getPin)->exists()) {
                            $getManager = AreaManager::where('assignedPincode', $getPin)->first();
                            $newCom = new ManagerCommision();
                            $newCom->mid = $getManager->id;
                            $newCom->user_id = $request->user()->id;
                            $newCom->coins = 1;
                            $newCom->fromPincode = $getPin;
                            $newCom->claimed = 'yes';
                            $newCom->save();
                            $getManager->increment('availableBalance', $newCom->coins);
                        } else {
                            $newCom = new ManagerCommision();
                            $newCom->mid = null;
                            $newCom->user_id = $request->user()->id;
                            $newCom->coins = 1;
                            $newCom->fromPincode = $getPin;
                            $newCom->claimed = 'no';
                            $newCom->save();
                        }
                        //distribute mlm commision
                        $this->distributeCommission($request->user(), $get_task->reward_coin);
                        

                        //end commission share

                        return response()->json([
                            'reward' => $get_task->reward_coin,
                            'status' => true,
                            'message' => 'All Answer Done'
                        ]);
                        //end

                        //end commission share

                        return response()->json([
                            'reward' => $get_task->reward_coin,
                            'status' => true,
                            'message' => 'All Answer Done'
                        ]);
                    }
                    $i++;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Answer Wrong'
                    ]);
                }
            }
        }
    }
    protected $commissionRates = [
        DB::table('commissions')->pluck('rate')->toArray()
    ];
    public function distributeCommission(User $user, int $amount)
    {
        DB::transaction(function () use ($user, $amount) {
            $referrer = $user->referrer;
            $level = 0;

            while ($referrer && $level < 10) {
                $commission = ceil($amount * ($this->commissionRates[$level] / 100));

                // Update referrer's balance
              //  $referrer->increment('balance', $commission);
                $result = (new WalletManage)->AddPayment($referrer->id, $commission, "Level " . ($level + 1) . " commission from " . $user->name, 'commission');
                // Create a transaction record
                // Transaction::create([
                //     'user_id' => $referrer->id,
                //     'amount' => $commission,
                //     'type' => 'commission',
                //     'description' => "Level " . ($level + 1) . " commission from " . $user->name,
                // ]);

                // Move up to the next referrer
                $referrer = $referrer->referrer;
                $level++;
            }
        });
    }
}
