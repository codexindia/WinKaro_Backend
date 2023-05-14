<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompleteOffers;

class OffersController extends Controller
{
    public function check_status(Request $request)
    {
        $main = CompleteOffers::where('user_id',$request->user()->id)->get(['name','status']);
      return response()->json([
        'status' => true,
        'data' => $main,
        'message' => 'Offers status',
      ]);
    }
}
