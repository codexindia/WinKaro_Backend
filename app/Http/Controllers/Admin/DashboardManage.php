<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CompleteTask;
use App\Models\AllTasks;
use App\Models\WithdrawRequest;
class DashboardManage extends Controller
{
    public function index()
    {
        $main['total_users'] = User::all()->count();
        $main['expired_task'] = AllTasks::where('status','expired')->count();
        $main['pending_submissions'] = CompleteTask::where('status','processing')->count();
        $main['pending_withdraw'] = WithdrawRequest::where('status','processing')->count();
        return view('admin.dashboard',compact('main'));
    }
}
