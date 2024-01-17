<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersManage extends Controller
{
    public function index(Request $request)
    {
        if ($request->q == '')
            $list = User::orderBy('id', 'desc')->paginate(10);
        else {
            $list = User::where('name','LIKE','%'.$request->q.'%')
            ->orWhere('phone','LIKE','%'.$request->q.'%')
            ->orWhere('email','LIKE','%'.$request->q.'%')
            ->orderBy('id', 'desc')->paginate(10);
        }
        $view = 'List';
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
}
