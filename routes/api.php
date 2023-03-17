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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register','ApiAuth@register');

Route::post('/verifyotp','ApiAuth@verifyotp');
Route::post('/login','ApiAuth@login');

//Route::middleware('auth:sanctum')->group(function () {
   
//});
