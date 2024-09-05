<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagerCommision;
use Illuminate\Support\Facades\DB; // Add this line to import the DB facade

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $taskRecord = ManagerCommision::select([
            DB::raw('COUNT(DISTINCT user_id) as totalUsers'),
            DB::raw('COUNT(DISTINCT CASE WHEN DATE(created_at) = CURDATE() THEN user_id END) as todayUsers'),
            DB::raw('COUNT(CASE WHEN claimed = "yes" THEN 1 END) as totalCompleted'),
            DB::raw('COUNT(CASE WHEN claimed = "yes" AND DATE(created_at) = CURDATE() THEN 1 END) as todayCompleted'),
           // DB::raw('SUM(CASE WHEN claimed = "YES" THEN coins ELSE 0 END) as availableCoins'),
            DB::raw('SUM(CASE WHEN claimed = "no" THEN coins ELSE 0 END) as pendingCoins')
        ])->where('mid',auth('manager')->user()->id)->first();
            
        if ($taskRecord) {
            $data['totalUsers'] = $taskRecord->totalUsers;
            $data['todayUsers'] = $taskRecord->todayUsers;
            $data['totalCompleted'] =  $taskRecord->totalCompleted;
            $data['todayCompleted'] =  $taskRecord->todayCompleted;
            $data['availableCoins'] =  auth('manager')->user()->availableBalance??0;
            $data['pendingCoins'] =  $taskRecord->pendingCoins??0;
        }
        return view('manager.dashboard', $data);
    }
}
