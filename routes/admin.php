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
    // Artisan::call('storage:link');
});
Route::get('/install', function () {
    // Artisan::call('migrate');
});


Route::get('/sendtoall', 'AuthManage@test');


Route::get('/', function () {
    return redirect(route('login_index'));
});
Route::controller('AuthManage')->middleware('admin.guest')->group(function () {
    Route::get('/Login', 'index')->name('login_index');
    Route::post('/Login', 'login_attempt')->name('login_attempt');
    Route::get('/Logout', 'logout_attempt')->name('logout_attempt')->withoutMiddleware('admin.guest');
    Route::get('/Logout/{token}', 'logout_token')->name('logout_token')->withoutMiddleware('admin.guest');
});

Route::middleware('admin.auth')->group(function () {

    Route::controller('DashboardManage')->group(function () {
        Route::get('/Dashboard', 'index')->name('dashboard');
    });
    Route::controller('TaskManage')->prefix('Tasks')->group(function () {
        Route::get('/', 'index')->name('task.index');
        Route::get('/New', 'new')->name('task.new');
        Route::get('/Edit/{id}', 'task_edit')->name('task.edit');
        Route::get('/Delete/{task_id}', 'task_delete')->name('task.delete');

        Route::post('/Edit/Submit', 'task_update')->name('task.update');
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
        Route::post('/Popup', 'push_popup')->name('notification.push_popup');
    });

    Route::controller('UsersManage')->prefix('Users')->group(function () {
        Route::get('/', 'index')->name('users.list');
        Route::get('/view/{id}', 'view_details')->name('users.view_details');
        Route::get('/Action/{Action}/{id}', 'action_perform')->name('users.action_perform');
        Route::post('/Transaction', 'action_transaction')->name('users.action_transaction');
    });


    Route::controller('WithdrawManage')->prefix('Withdrawls')->group(function () {
        Route::get('/', 'index')->name('withdraw.index');
        Route::get('/Action/{Action}/{id}', 'action')->name('withdraw.action');
    });

    Route::controller('Settingsmanage')->name('settings.')->prefix('Settings')->group(function () {
        Route::get('/App_update', 'app_update')->name('appupdate');
        Route::post('/App_update', 'app_update_push')->name('appupdate.push');
    });
    Route::controller('OfferManage')->name('offers.')->prefix('Offers')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/telegram_checklist/status/{id}/{action}', 'telegram_checklist_status')->name('telegram.status');
        Route::get('/app_install', 'app_install')->name('app_install');
        Route::post('/app_install', 'app_install_publish')->name('app_install_publish');
    });
    Route::controller('AreaManager')->name('manager.')->prefix('Managers')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/createNewPage', 'createNewPage')->name('createNewPage');
        Route::post('/createNewSubmit', 'createNewSubmit')->name('createNewSubmit');
        Route::get('/withdrawal', 'withdrawalList')->name('withdrawalList');
    });
});
