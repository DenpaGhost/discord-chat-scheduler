<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthorizeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenGrantRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TokenController extends Controller
{
    private AuthorizeAction $action;

    /**
     * TokenController constructor.
     * @param AuthorizeAction $action
     */
    public function __construct(AuthorizeAction $action)
    {
        $this->action = $action;
    }

    /**
     * @param TokenGrantRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function store(TokenGrantRequest $request)
    {
        $client_id = $request->input('client_id');

        $this->action->validateAuthClientId($client_id);

        /** @var 'authorization_code'|'refresh_token' $grant_type */
        $grant_type = $request->input('grant_type');
        if ($grant_type === 'authorization_code') {
            return $this->action->grantToken(
                $client_id,
                $request->input('code'),
                $request->input('code_verifier')
            );
        } else if ($grant_type === 'refresh_token') {
            return $this->action->refreshToken(
                $client_id,
                $request->input('refresh_token')
            );
        }

        return response()->json([], 404);
    }

    /**
     * @param $token
     * @return Application|ResponseFactory|Response
     */
    public function destroy($token)
    {
        if ($this->action->expireToken($token)) {
            return response('', 200);
        } else {
            return response('', 404);
        }
    }
}
