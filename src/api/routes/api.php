<?php

use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Guilds\GuildController;
use App\Http\Controllers\Tasks\TaskManagementController;
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
Route::apiResource('/auth/token', TokenController::class)
    ->only(['store', 'destroy']);

Route::apiResource('/servers', GuildController::class)
    ->only(['index', 'show'])
    ->parameter('servers', 'guild_id')
    ->middleware('authentication');

Route::apiResource('/servers/{guild_id}/tasks', TaskManagementController::class)
    ->middleware(['authentication', 'available-guild']);
