<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['totalUsers'] = 100;
        $data['todayUsers'] = 100;
        $data['totalCompleted'] = 100;
        $data['todayCompleted'] = 50;
        $data['availableCoins'] = 50;
        $data['pendingCoins'] = 25;
        return view('manager.dashboard',$data);
    }
}
