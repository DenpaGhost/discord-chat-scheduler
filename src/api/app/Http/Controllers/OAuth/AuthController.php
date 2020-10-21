<?php

namespace App\Http\Controllers\OAuth;

use App\Actions\AuthAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function start(Request $request, AuthAction $action)
    {
        // todo フォームリクエストバリデーションをつくる
        return $action->startDiscordAuthorizing(
            $request->input('client_id'),
            $request->input('state'),
            $request->input('code_challenge'));
    }

    public function callback(Request $request, AuthAction $action)
    {
        return $action->makeCode($request->input('state'), $request->input('code'));
    }
}
