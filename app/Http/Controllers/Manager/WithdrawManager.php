<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawManager extends Controller
{
    public function index(){
        $data['availableBalance'] = auth('manager')->user()->availableBalance;
        return view('manager.withdraw',$data);
    }
}
