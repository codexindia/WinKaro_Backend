<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\AllTasks;
class TaskStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Here Task Status Will Change in Every Minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AllTasks::where('expire_at','<', Carbon::now())->where('status','active')->update([
            'status' => 'expired',
         ]);
         return "Task Complete";
    }
}
