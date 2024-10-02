<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\WalletManage;
use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AreaManager;
class UsersManage extends Controller
{
    public function action_transaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:credit,debit'
        ]);
        if ($request->type == 'debit') {
            $result = (new WalletManage)->CutPayment($request->user_id, $request->amount, 'Amount Debit By Admin', 'reward');
        } elseif ($request->type == 'credit') {
            $result = (new WalletManage)->AddPayment($request->user_id, $request->amount, 'Amount Credit By Admin', 'reward');
        }
        return back()->with(['success', 'Transaction Execute SuccessFully']);
    }
    public function index(Request $request)
    {
        if ($request->q == '')
            $list = User::orderBy('id', 'desc')->paginate(10);
        else {
            $list = User::where('name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%')
                ->orderBy('id', 'desc')->paginate(10);
        }
        $view = 'List';
        $list->appends($request->all());
        return view('admin.users', compact('list', 'view'));
    }
    public function view_details(Request $request)
    {
        $data = User::where('id', $request->id)->first();
        $view = 'details';
        return view('admin.users', compact('data', 'view'));
    }
    public function action_perform(Request $request)
    {
        if ($request->Action == 'Active') {
            User::find($request->id)->UserBlocked()->delete();
            return back()->with(['success' => 'User Activated SuccessFully']);
        } else if ($request->Action == 'Deactive') {
            User::find($request->id)->UserBlocked()->create([
                'reasons' => 'You Have Been Blocked By Admin',
            ]);
            return back()->with(['success' => 'User Deactivated SuccessFully']);
        }
    }
    public function referralsIndex(Request $request)
    {
        return view('admin.mlm.referrals.index');
    }
    public function referralsSearch(Request $request)
    {
        $referCode = $request->input('refer_code');
        $mainUser = User::where('refer_code', $referCode)->first();

        if (!$mainUser) {
            return redirect()->route('referrals.index')->with('error', 'User not found.');
        }

        $referrals = $this->getReferrals($mainUser, 10);

        return view('admin.mlm.referrals.index', compact('mainUser', 'referrals'));
    }
    private function getReferrals($user, $level, $currentLevel = 1)
    {
        if ($currentLevel > $level) {
            return [];
        }

        $referrals = $user->referrals()->with('referrals')->get();

        foreach ($referrals as $referral) {
            $referral->sub_referrals = $this->getReferrals($referral, $level, $currentLevel + 1);
        }

        return $referrals;
    }
    public function MlmCommissions(Request $request)
    {
        $commissions = Commission::all();
        return view('admin.mlm.commissions.index', compact('commissions'));
   }
   public function SetMlmCommissions(Request $request)
   {
       $data = $request->validate([
           'commissions' => 'required|array',
           'commissions.*' => 'required|numeric|min:0|max:100',
       ]);

       foreach ($data['commissions'] as $level => $commission) {
           Commission::updateOrCreate(['level' => $level + 1], ['percentage' => $commission]);
       }

       return redirect()->route('commissions.index')->with('success', 'Commissions updated successfully.');
   }
  
}
