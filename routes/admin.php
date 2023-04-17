<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/foo', function () {
    Artisan::call('storage:link');
});
Route::get('/install', function () {
    Artisan::call('migrate');
});


Route::get('/sendtoall', 'AuthManage@test');


Route::get('/', function () {
    return redirect(route('login_index'));
});
Route::controller('AuthManage')->middleware('admin.guest')->group(function () {
    Route::get('/Login', 'index')->name('login_index');
    Route::post('/Login', 'login_attempt')->name('login_attempt');
});

Route::middleware('admin.auth')->group(function () {
    Route::controller('DashboardManage')->group(function () {
        Route::get('/Dashboard', 'index')->name('dashboard');
    });
    Route::controller('TaskManage')->prefix('Tasks')->group(function () {
        Route::get('/', 'index')->name('task.index');
        Route::get('/New', 'new')->name('task.new');
        Route::post('/Create', 'create')->name('task.create');
        //submission checks
        Route::get('/Submissions', 'submission_list')->name('task.submission_list');
        Route::get('/Submissions/View/{id}', 'submission_details')->name('task.submission_details');
        Route::post('/Submissions/Status/{Action}', 'change_status')->name('task.change_status');
    });
    Route::controller('BannersController')->prefix('Banners')->group(function () {
        Route::get('/', 'index')->name('banners.index');
        Route::post('/', 'upload')->name('banners.upload');
        Route::get('/delete/{id}', 'delete')->name('banners.delete');
    });
    Route::controller('NotificationManage')->prefix('Notifications')->group(function () {
        Route::get('/', 'index')->name('notification.index');
        Route::post('/Push', 'push_alert')->name('notification.push_alert');
    });

    Route::controller('UsersManage')->prefix('Users')->group(function () {
        Route::get('/', 'index')->name('users.list');
        Route::get('/view/{id}', 'view_details')->name('users.view_details');
        Route::get('/Action/{Action}/{id}', 'action_perform')->name('users.action_perform');
    });
    Route::controller('WithdrawManage')->prefix('Withdrawls')->group(function () {
        Route::get('/', 'index')->name('withdraw.index');
        Route::get('/Action/{Action}/{id}', 'action')->name('withdraw.action');
    });
});