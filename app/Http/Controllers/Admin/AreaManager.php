<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaManager as AreaManagerModel;
use App\Models\ManagerWithdrawals;

class AreaManager extends Controller
{
    public function index()
    {
        $data['view'] = "List";
        $data['allAreaManagers'] = AreaManagerModel::orderBy('id','desc')->paginate(10);
        return view('admin.area-manager.index',$data);
    }
    public function createNewPage(Request $request)
    {
        return view('admin.area-manager.create');
    }
    public function createNewSubmit(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone_number' => 'required|numeric|digits:10|unique:area_managers,phoneNumber',
            'assigned_pincode'=>'required|numeric|digits:6|unique:area_managers,assignedPincode',
             'password' => 'required|min:6|max:20',
        ]);
        $newManager = new AreaManagerModel();
        $newManager->fullName = $request->full_name;
        $newManager->phoneNumber = $request->phone_number;
        $newManager->assignedPincode = $request->assigned_pincode;
        $newManager->password = bcrypt($request->password);
        $newManager->save();
        return redirect()->route('manager.index')->with(['success'=>'Area Manager created successfully']);
    }
    public function withdrawalList()
    {
        $data['withdrawals'] = ManagerWithdrawals::orderBy('id', 'desc')->where('status','pending')->get();
        return view('admin.managerWithdrawl', $data);
    }
    public function withdrawalAction(Request $request)
    {
        $withdrawal = ManagerWithdrawals::find(request()->id);
        $withdrawal->status = $request->Action;
        $withdrawal->save();
        return redirect()->route('manager.withdrawalList')->with(['success'=>'Withdrawal status updated successfully']);
    }
}
