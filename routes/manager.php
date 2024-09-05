<?php 
use Illuminate\Support\Facades\Route;


Route::get('/login','AuthManager@loginPage')->name('manager.login');
Route::post('/login','AuthManager@loginPageSubmit')->name('manager.loginPageSubmit');

Route::middleware('manager.auth')->group(function(){
    Route::get('/Dashboard','DashboardController@index')->name('manager.dashboard');
    Route::get('/logout','DashboardController@logout')->name('manager.logout');
    Route::prefix('withdraw')->controller('WithdrawManager')->group(function(){
         Route::get('/','WithdrawManager@index')->name('manager.withdraw');
         Route::post('/','WithdrawManager@submitWithdraw')->name('manager.withdraw.submit');
    });
});