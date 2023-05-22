<?php

namespace App\Console\Commands;

use App\Models\CompleteTask;
use Illuminate\Console\Command;
use App\Models\ReferHistory;
use App\Http\Controllers\Api\WalletManage;

class ReferStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refer-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $get_pendings = ReferHistory::limit(10)->where('status', 'pending')->get();
        //loop for origin users only
        foreach ($get_pendings as $get) {
            $get_completed_task  = CompleteTask::where([
                'user_id' => $get->referred_user_id,
                'status' => 'complete',
            ])->get('type');
            $status = 1;
            //loop to check if referred user complete the task continues
            foreach ($get_completed_task as $item) {
                if ($item->type == 'youtube') {
                    $status += 1;
                } else {
                    $status = 0;
                }
                if ($status == 10) {
                    ReferHistory::find($get->id)->update([
                        'status' => 'success',
                    ]);
                    $result = (new WalletManage)->AddPayment($get->refer_by_user_id, $get->reward_coin, 'For Refer New User', 'reward');
                    break;
                }
            }
            //end of checking
        }
    }
}
