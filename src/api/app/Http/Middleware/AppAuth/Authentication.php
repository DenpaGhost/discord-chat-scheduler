<?php

namespace App\Http\Middleware\AppAuth;

use App\Actions\Auth\AuthenticationAction;
use Closure;
use Illuminate\Http\Request;

class Authentication
{
    private AuthenticationAction $action;

    /**
     * Authentication constructor.
     * @param AuthenticationAction $action
     */
    public function __construct(AuthenticationAction $action)
    {
        $this->action = $action;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->action->authentication($request->header('Authorization'))) {
            return response()->json([], 401);
        }
        return $next($request);
    }
}
