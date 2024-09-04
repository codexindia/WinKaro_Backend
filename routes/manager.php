<?php 
use Illuminate\Support\Facades\Route;


Route::get('/login','AuthManager@loginPage')->name('manager.login');
Route::post('/login','AuthManager@loginPageSubmit')->name('manager.loginPageSubmit');

Route::middleware('manager.auth')->group(function(){
    Route::get('/Dashboard','DashboardController@index')->name('manager.dashboard');
    Route::get('/logout','DashboardController@logout')->name('manager.logout');
});