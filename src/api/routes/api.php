<?php

use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Guilds\GuildController;
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
    /** @var \App\Models\User $user */
    $user = Auth::user();
    return $user;
})->middleware('authentication');

Route::resource('/user/guilds', GuildController::class)
    ->only('index')
    ->middleware('authentication');
