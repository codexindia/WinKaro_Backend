<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppUpdate;
use Illuminate\Http\Request;

class Settingsmanage extends Controller
{
    public function app_update()
    {
        $old = AppUpdate::latest()->first();
        return view('admin.settings.appupdate',compact('old'));
    }
    public function app_update_push(Request $request)
    {
        $request->validate([
            'version_code' => 'required|numeric',
            'app_link' => 'required|url'
        ]);
        AppUpdate::create([
            'version_code' => $request->version_code,
            'app_link' => $request->app_link,
        ]);
        return back()->with(['success' => 'App Update Alert Pushed Successfully']);
    }
}
