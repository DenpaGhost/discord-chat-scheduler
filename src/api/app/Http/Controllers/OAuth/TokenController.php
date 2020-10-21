<?php

namespace App\Http\Controllers\OAuth;

use App\Actions\AuthAction;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    private AuthAction $action;

    /**
     * @param string $code
     * @param string $code_verifier
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws ModelNotFoundException
     */
    public function grantToken(string $code, string $code_verifier)
    {
        return $this->action->grantToken($code, $code_verifier);
    }
}
