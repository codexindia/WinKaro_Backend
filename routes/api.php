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

    Route::controller('ProfileController')->prefix('profile')->group(function () {
        Route::post('/get_user', 'getuser');
        Route::post('/update_profile', 'update_profile');
    });

    Route::controller('WalletManage')->prefix('wallet')->group(function () {
        Route::post('/bind_account', 'bind_ac');
        Route::post('/get_account', 'get_account');
        Route::post('/get_transactions/{type}','get_transactions');
        Route::post('/withdraw','withdraw');
        
    });

    Route::controller('SpinAndEarn')->prefix('spin_and_earn')->group(function () {
        Route::post('/add_reward', 'add_reward');
        Route::post('/get_spin_coin', 'get_spin_coin');
    });

    Route::controller('WatchAndEarn')->prefix('watch_and_earn')->group(function () {
        Route::post('/add_reward', 'add_reward');
        Route::post('/get_reward_video', 'get_reward_video');
    });
    Route::controller('NotificationManage')->prefix('notifications')->group(function () {
        Route::post('/get_notification', 'get_notification');
        Route::post('/mark_read', 'mark_read');
    });
    Route::controller('TaskManage')->prefix('tasks')->group(function () {
        Route::post('/get/{type}', 'get_tasks');
        Route::post('/submit/task', 'submit_task');
    });
    Route::controller('BannersManage')->prefix('banners')->group(function () {
        Route::post('/get', 'get_banner');
       
    });
});