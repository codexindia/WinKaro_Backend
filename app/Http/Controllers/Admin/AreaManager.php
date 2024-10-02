<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaManager as AreaManagerModel;
use App\Models\ManagerWithdrawals;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AreaManager extends Controller
{
    public function index()
    {
        $data['view'] = "List";
        $data['allAreaManagers'] = AreaManagerModel::orderBy('id', 'desc')->paginate(10);
        return view('admin.area-manager.index', $data);
    }
    public function saveOverAllCommission(Request $request)
    {
        $request->validate([
            'commission' => 'required|numeric|lte:100',
        ]);
    DB::table('area_managers')->update(['commissionPercentage' => $request->commission]);
        return redirect()->route('manager.index')->with(['success' => 'Commission updated successfully']);
    }
    public function createNewPage(Request $request)
    {
        $data['defaultCom'] = AreaManagerModel::first()->commissionPercentage??0;
        return view('admin.area-manager.create',$data);
    }
    public function createNewSubmit(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone_number' => 'required|numeric|digits:10|unique:area_managers,phoneNumber',
            'assigned_pincode' => 'required|numeric|digits:6|unique:area_managers,assignedPincode',
            'password' => 'required|min:6|max:20',
            'commission' => 'required|numeric|lte:100',
        ]);
        $newManager = new AreaManagerModel();
        $newManager->fullName = $request->full_name;
        $newManager->phoneNumber = $request->phone_number;
        $newManager->assignedPincode = $request->assigned_pincode;
        $newManager->commissionPercentage = $request->commission;
        $newManager->password = bcrypt($request->password);
        $newManager->save();
        return redirect()->route('manager.index')->with(['success' => 'Area Manager created successfully']);
    }
    public function withdrawalList()
    {
        $data['withdrawals'] = ManagerWithdrawals::orderBy('id', 'desc')->where('status', 'pending')->get();
        return view('admin.managerWithdrawl', $data);
    }
    public function withdrawalAction(Request $request)
    {
        $withdrawal = ManagerWithdrawals::find(request()->id);
        $withdrawal->status = $request->Action;
        $withdrawal->save();
        return redirect()->route('manager.withdrawalList')->with(['success' => 'Withdrawal status updated successfully']);
    }
    public function deleteAreaManager(Request $request)
    {
        AreaManagerModel::find($request->id)->delete();

        return back()->with(['success' => 'Area Manager removed successfully.']);
    }
    public function editAreaManager(Request $request)
    {
        $areamanager = AreaManagerModel::find($request->id);
        //   return  $areamanager;
        return view('admin.area-manager.edit', compact('areamanager'));
    }
    public function editSubmitAreaManager(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone_number' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('area_managers','phoneNumber')->ignore($request->userId),
            ],

            'assigned_pincode' => [
                'required',
                'numeric',
                'digits:6',
                Rule::unique('area_managers', 'assignedPincode')->ignore($request->userId),
            ],
            'password' => 'nullable|min:6|max:20',
            'userId' => 'required|exists:area_managers,id',
            'commission' => 'required|numeric|lte:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $newManager = AreaManagerModel::find($request->userId);
        $newManager->fullName = $request->full_name;
        $newManager->phoneNumber = $request->phone_number;
        $newManager->assignedPincode = $request->assigned_pincode;
        $newManager->commissionPercentage = $request->commission;
        if ($request->has('password')) {
            $newManager->password = bcrypt($request->password);
        }

        $newManager->save();
        return redirect()->route('manager.index')->with(['success' => 'Area Manager Updated successfully']);
    }
}
