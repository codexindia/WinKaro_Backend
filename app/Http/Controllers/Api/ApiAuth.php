<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerification;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiAuth extends Controller
{



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
        ]);
        $refer_code = 'WIN' . rand('100000', '999999');
        $user = User::create([
            'name' => $request->name,
            'refer_code' => $refer_code,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);



        DB::table('access_logs')->insert([
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'action' => 'User Registration',
        ]);

        #sending An OTP To Verify User
          $this->sendotp($user->phone);
        return response()->json([
            'status' => true,
            'message' => 'User Registration SuccessFully',
        ]);

    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|exists:users,phone'
        ]);
        $res = $this->sendotp($request->phone);
        return response()->json([
            'status' => true,
            'message' => $res['message']
        ]);
    }




    //genaret otp
    private function sendotp($number)
    {
        $user = User::where('phone', $number)->first();
        $id = $user->id;
        $checkotp = UserVerification::where('user_id', $id)->latest()->first();
        //dd($checkotp);
        $now = Carbon::now();
        if ($checkotp && $now->isBefore($checkotp->expire_at)) {
            $otp = $checkotp->otp;
        } else {
            $otp = rand('100000', '999999');
            UserVerification::create([
                'user_id' => $id,
                'otp' => $otp,
                'expire_at' => Carbon::now()->addMinute(10)
            ]);
        }
        try {
            $response = Http::withHeaders([
                'authorization' => '2YynG6A9OsjBrx8JFEZhKNdWq30m1DoapwPilRuQbHIfkM4SvVSI6dELhpNAj7GkD3PTy0bXnaCvifz2',
                'accept' => '*/*',
                'cache-control' => 'no-cache',
                'content-type' => 'application/json'
            ])->post('https://www.fast2sms.com/dev/bulkV2', [
                    "variables_values" => $otp,
                    "route" => "otp",
                    "numbers" => $number,
                ]);

            return json_decode($response, true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    //verify otp
    public function verifyotp(Request $request)
    {

        $request->validate([
            'otp' => 'required|numeric|digits:6',
            'phone' => 'required|numeric|exists:users,phone'
        ]);
        $userdata = User::where('phone', $request->phone)->first();

        $userid = $userdata->id;
        $checkotp = UserVerification::where('user_id', $userid)
            ->where('otp', $request->otp)->latest()->first();
        $now = Carbon::now();
        if (!$checkotp) {
            return response()->json([
                'status' => false,
                'message' => 'Your OTP Is Invalid'
            ]);
        } elseif ($checkotp && $now->isAfter($checkotp->expire_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Your OTP Has Expired'
            ]);
        } else {
            if ($request->has('device_name'))
                $device = $request->device_name;
            else
                $device = 'Auth_Token';
            $token = $userdata->createToken($device)->plainTextToken;
            UserVerification::where('user_id', $userid)->delete();
            return response()->json([
                'status' => true,
                'token' => $token,
                'message' => 'Your OTP Has Verified SuccessFully'
            ]);
        }
    }
}