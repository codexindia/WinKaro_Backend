<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerification;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\WalletManage;
use App\Models\ReferHistory;

class ApiAuth extends Controller
{



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'device_id' => 'required',
            'refer_code' => 'min:10|max:10|exists:users,refer_code'
        ]);
        //checking if device already registerd
        $device_id = $request->device_id;
        $detect = DB::table('device_detection')->where([
            'device_id' => $device_id,
        ]);
        if ($detect->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Your Device Already Registered With Different Number xxxxxx' . substr($detect->first()->phone_number, 6),
            ]);
        }
        //creating account
        $refer_code = 'ONEAP' . rand('100000', '999999');
        $balance = 0;
        if ($request->has('refer_code')) {
            $main_user = User::where('refer_code', $request->refer_code)->first();
        }


        $user = User::create([
            'name' => $request->name,
            'refer_code' => $refer_code,
            'email' => $request->email,
            'phone' => $request->phone,
            'referred_by' => $request->refer_code,
        ]);
        //for new user
        if ($request->has('refer_code')) {
            $balance = 200;
            $newpay = (new WalletManage)->AddPayment($user->id, $balance, 'Reward For Refer Code', 'reward');

            ReferHistory::create([
                'refer_by_user_id' => $main_user->id,
                'referred_user_id' => $user->id,
                'reward_coin' => 500,
                'status' => 'pending',
            ]);
            $newpay = (new WalletManage)->AddPayment($main_user->id, 500, 'Reward For Refer Users', 'reward');
        }

        //adding data to device detection to prevent spam registration
        DB::table('device_detection')->insert([
            'device_id' => $device_id,
            'phone_number' => $request->phone,
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
            'message' => 'User Registration SuccessFully'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'phone' => 'required|numeric|digits:10|exists:users,phone',

            ],
            [
                'phone.exists' => 'Phone Number Has Not Registered'
            ]
        );


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
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);
        }
        try {
            $response = Http::withOptions(['verify' => false])->withHeaders([
                'authorization' => 'xHJicy25FB7MKaRVf6LwkYSIXoluUbOP43zTWCvp8019tgjeAdo90pJ5x6q32dE1ZrCP4aONUmsjtBlD',
                'accept' => '*/*',
                // 'cache-control' => 'no-cache',
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
        //for temporary playsotre rules
        if ($request->phone == '1234567890') {
            $device = 'Auth_Token';
            $token = $userdata->createToken($device)->plainTextToken;
            return response()->json([
                'status' => true,
                'token' => $token,
                'message' => 'Your OTP Has Verified SuccessFully'
            ]);
        }

        //remove after published at play store


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
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        DB::table('access_logs')->insert([
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'action' => 'User Logged Out',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'User Logged Out SuccessFully',
        ]);
    }
}
