<?php

namespace App\Http\Controllers\OAuth;

use App\Actions\AuthAction;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    private AuthAction $action;

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function __invoke(Request $request)
    {
        /** @var 'authorization_code'|'refresh_token' $grant_type */
        $grant_type = $request->input('grant_type');
        if ($grant_type === 'authorization_code') {
            return $this->action->grantToken(
                $request->input('code'),
                $request->input('code_verifier')
            );
        } else if ($grant_type === 'refresh_token') {
            // todo トークンリフレッシュアクションの実装
        }

        return response()->json([], 404);
    }
}
