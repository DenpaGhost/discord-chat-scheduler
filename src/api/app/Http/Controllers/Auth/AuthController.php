<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthorizeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizationRequest;
use App\Http\Requests\Auth\CallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthorizeAction $action;

    /**
     * AuthController constructor.
     * @param AuthorizeAction $action
     */
    public function __construct(AuthorizeAction $action)
    {
        $this->action = $action;
    }

    /**
     * 認可処理のスタート
     * @param AuthorizationRequest $request
     * @return RedirectResponse
     */
    public function start(AuthorizationRequest $request)
    {
        $client_id = $request->input('client_id');
        $this->action->validateAuthClientId($client_id);

        return $this->action->startDiscordAuthorizing(
            $request->input('client_id'),
            $request->input('state'),
            $request->input('code_challenge'));
    }

    /**
     * Discord認可後のリダイレクトを受ける
     * @param CallbackRequest $request
     * @return RedirectResponse
     */
    public function callback(CallbackRequest $request)
    {
        return $this->action->makeCode($request->input('state'), $request->input('code'));
    }
}
