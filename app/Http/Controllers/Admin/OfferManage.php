<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\WalletManage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompleteOffers;
class OfferManage extends Controller
{
    public function index()
    {
        
        $getalloffers = CompleteOffers::where([
            'status'=>'complete',
        ])->orderBy('id','desc')->paginate(10);
        $telegram_checklist = CompleteOffers::where(
            [
                'status'=>'processing',
                'name' => 'telegram_task'
            ]
        )->orderBy('id','desc')->paginate(10);
        return view('admin.offers.index',compact('getalloffers','telegram_checklist'));
    }
    public function telegram_checklist_status(Request $request)
    {
        if($request->action == 'reject')
        {
            CompleteOffers::FindOrFail($request->id)->delete();
            return back()->with(['success' => 'Offer Submission Removed Successfully']);
        }elseif($request->action == 'accept')
        {
            $root = CompleteOffers::FindOrFail($request->id);
            $user_id = $root->user_id;
            $root->update([
                'status' => 'complete',
            ]);
            $result = (new WalletManage)->AddPayment($user_id,'100', 'For Joining Telegram Channel','reward');
            return back()->with(['success' => 'Offer Submission Accept Successfully']);
        }
    }
}
