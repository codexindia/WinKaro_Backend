<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UsersManage extends Controller
{
    public function index()
    {
        $list = User::orderBy('id','desc')->get();
        $view = 'List';
        return view('admin.users',compact('list','view'));
    }
}
