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

Route::get('/', function () {
    return redirect(route('login_index'));
});
Route::controller('AuthManage')->group(function(){
    Route::get('/Login','index')->name('login_index');
    Route::post('/Login','login_attempt')->name('login_attempt');
});

