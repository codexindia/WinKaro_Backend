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
Route::get('/privacy_policy','ExtraPages@privacy_policy');
Route::get('/terms_and_conditions','ExtraPages@terms_and_conditions');

Route::get('/test',function(){
    return view('test');
});