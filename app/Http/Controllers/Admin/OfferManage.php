<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfferManage extends Controller
{
    public function index()
    {
        return view('admin.offers.index');
    }
}
