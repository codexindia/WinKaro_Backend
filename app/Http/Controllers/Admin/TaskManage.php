<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskManage extends Controller
{
   public function index()
   {
    $view = "list";
    return view('admin.tasks',compact('view'));
   }
}
