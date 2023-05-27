<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\WalletManage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompleteOffers;
use App\Models\InstallOffer;

class OfferManage extends Controller
{
    public function index()
    {

        $getalloffers = CompleteOffers::where([
            'status' => 'complete',
        ])->orderBy('id', 'desc')->limit('10')->get();
        $checklist = CompleteOffers::where(
            [
                'status' => 'processing',
                //'name' => 'telegram_task'
            ]
        )->orderBy('id', 'desc')->paginate(10);
        return view('admin.offers.index', compact('getalloffers', 'checklist'));
    }
    public function telegram_checklist_status(Request $request)
    {
        if ($request->action == 'reject') {
            CompleteOffers::FindOrFail($request->id)->delete();
            return back()->with(['success' => 'Offer Submission Removed Successfully']);
        } elseif ($request->action == 'accept') {
            $root = CompleteOffers::FindOrFail($request->id);
            $user_id = $root->user_id;
            $root->update([
                'status' => 'complete',
            ]);
            if ($root->name == 'app_install_task') {
                $result = (new WalletManage)->AddPayment($user_id, '200', 'For Completing Install Offer', 'reward');
            } elseif ($root->name == 'telegram_task') {
                $result = (new WalletManage)->AddPayment($user_id, '100', 'For Joining Telegram Channel', 'reward');
            }
            return back()->with(['success' => 'Offer Submission Accept Successfully']);
        }
    }
    public function app_install(Request $request)
    {
        $old = InstallOffer::latest()->first();
        return view('admin.offers.app_install', compact('old'));
    }
    public function app_install_publish(Request $request)
    {
        $request->validate([
            'video_link' => 'required|url',
            'app_link' => 'required|url',
        ]);
        InstallOffer::updateOrCreate(
            ['id' => 1],
            ['video_link' => $request->video_link, 'app_link' => $request->app_link,]
        );
        CompleteOffers::where('name', 'app_install_task')->delete();
        return back()->with(['success' => 'offers updated successfully']);
    }
}
