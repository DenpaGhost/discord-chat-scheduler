<?php


namespace App\Functions\Auth;


use App\Models\Auth\Token;
use Illuminate\Database\Query\Builder;

class TokenFunction
{
    /**
     * アクセストークンからトークンオブジェクトの取得
     * @param string $access_token
     * @return Token|null
     */
    public function findTokenByAccessToken(string $access_token): ?Token
    {
        return Token::with(['user'])->accessToken($access_token)->first();
    }
}
