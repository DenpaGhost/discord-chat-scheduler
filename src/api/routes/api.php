<?php

use App\Http\Controllers\Auth\TokenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('/auth/token', TokenController::class)->only(['store', 'destroy']);

Route::get('/user/@me', function () {
    return Auth::user();
})->middleware('authentication');
