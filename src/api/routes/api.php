<?php

use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Guilds\GuildController;
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

Route::resource('/servers', GuildController::class)
    ->only(['index', 'show'])
    ->parameter('servers', 'guild_id')
    ->middleware('authentication');
