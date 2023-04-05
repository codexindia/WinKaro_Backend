<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller('ApiAuth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/verify_otp', 'verifyotp');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});


Route::middleware('auth:sanctum')->group(function () {

    Route::controller('ProfileController')->group(function () {
        Route::post('/get_user', 'getuser');
    });

    Route::controller('WalletSection')->prefix('wallet')->group(function () {
        Route::post('/bind_account', 'bind_ac');
        Route::post('/get_account', 'get_account');
    });
    Route::controller('SpinAndEarn')->prefix('spin_and_earn')->group(function () {
        Route::post('/add_reward', 'add_reward');
        Route::post('/get_spin_coin', 'get_spin_coin');
    });
});