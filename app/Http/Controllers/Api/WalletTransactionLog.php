<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\User;
class WalletTransactionLog extends Controller
{
    public function AddLog($user_id,$amount,$description,$status)
    {
        $new = new WalletTransaction;
        $new->user_id = $user_id;
        $new->amount = $amount;
        $new->description = $description;
        $new->status = $status;
        if($new->save())
        {
            User::find($user_id)->increment('balance',$amount);
        }
        
    }
}
