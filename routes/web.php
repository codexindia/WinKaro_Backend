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
    });

});