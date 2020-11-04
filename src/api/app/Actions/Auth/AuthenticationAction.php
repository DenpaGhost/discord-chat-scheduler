<?php


namespace App\Actions\Auth;


use App\Functions\Auth\TokenFunction;
use App\Functions\UserFunction;

class AuthenticationAction
{
    private UserFunction $user_func;
    private TokenFunction $token_func;

    /**
     * AuthenticationAction constructor.
     * @param UserFunction $user_func
     * @param TokenFunction $token_func
     */
    public function __construct(UserFunction $user_func, TokenFunction $token_func)
    {
        $this->user_func = $user_func;
        $this->token_func = $token_func;
    }

    /**
     * 認証
     * @param string $token
     * @return bool
     */
    public function authentication(string $token)
    {
        $obj = $this->token_func->findTokenByAccessToken($token);

        if ($obj === null) {
            return false;
        }

        $this->user_func->auth($obj->user_id);
        return true;
    }
}
