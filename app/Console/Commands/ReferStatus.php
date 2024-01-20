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
        $get_pendings = ReferHistory::where(['status' => 'pending'])->get();
        //loop for origin users only


        foreach ($get_pendings as $get) {
            $get_completed_count  = CompleteTask::where([
                'user_id' => $get->referred_user_id,
                'status' => 'complete',
            ])->count();
            $status = 1;
            if ($get_completed_count == 30) {
                ReferHistory::find($get->id)->update([
                    'status' => 'success',
                ]);
                $result = (new WalletManage)->AddPayment($get->refer_by_user_id, $get->reward_coin, 'For Refer New User', 'reward');
            }
            //loop to check if referred user complete the task continues

            //end of checking
        }
    }
}
