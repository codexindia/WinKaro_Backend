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
Route::controller('AppManage')->prefix('app')->group(function () {
    Route::post('/get_update', 'get_update');
});

Route::middleware('auth:sanctum','user.check')->group(function () {

    Route::controller('ProfileController')->prefix('profile')->group(function () {
        Route::post('/get_user', 'getuser');
        Route::post('/update_profile', 'update_profile');
    });
    Route::controller('ReferManage')->prefix('refer')->group(function () {
        Route::post('/get_history', 'get_history');
       
    });

    Route::controller('WalletManage')->prefix('wallet')->group(function () {
        Route::post('/bind_account', 'bind_ac');
        Route::post('/get_account', 'get_account');
        Route::post('/get_transactions/{type}', 'get_transactions');
        Route::post('/withdraw', 'withdraw');

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
        Route::post('/get_popup', 'get_popup');
        Route::post('/mark_read', 'mark_read');

    });
    Route::controller('TaskManage')->prefix('tasks')->group(function () {
        Route::post('/get/{type}', 'get_tasks');
        Route::post('/submit/task', 'submit_task');
        Route::post('/v2/submit/task', 'submit_task_v2');

    });
    Route::controller('BannersManage')->prefix('banners')->group(function () {
        Route::post('/get', 'get_banner');
    });
    Route::controller('OffersController')->prefix('offers')->group(function () {
        Route::post('/check_status', 'check_status');
        Route::post('/get/app_install_task', 'get_install_task');

        Route::post('/claim/yt_task_milestone', 'yt_task_milestone');
        Route::post('/claim/telegram_task', 'telegram_task');
        Route::post('/claim/app_install_task', 'app_install_task');
    });
});
