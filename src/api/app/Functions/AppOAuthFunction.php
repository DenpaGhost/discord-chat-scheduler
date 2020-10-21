<?php


namespace App\Functions;

use App\Models\OAuth\Auth;
use App\Models\OAuth\Token;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Class AppOAuthFunction
 *
 * Application Authorization Functions
 *
 * @package App\Functions
 */
class AppOAuthFunction
{
    // store information

    /**
     * 認可待ちデータの保存
     *
     * @param string $client_id
     * @param string $state
     * @param string $code
     * @param string $code_challenge
     * @param string $discord_token_id
     * @return Auth
     */
    public function storeState(
        string $client_id,
        string $state,
        string $code,
        string $code_challenge,
        string $discord_token_id
    ): Auth
    {
        return Auth::create([
            'client_id' => $client_id,
            'state' => $state,
            'code' => $code,
            'code_challenge' => $code_challenge,
            'discord_token_id' => $discord_token_id
        ]);
    }

    /**
     * stateから認可待ちデータの取得
     *
     * @param string $state
     * @return Auth|null
     */
    public function findByState(string $state): ?Auth
    {
        return Auth::state($state)->first();
    }

    /**
     * codeから認可待ちデータの取得
     *
     * @param string $code
     * @return Auth|null
     */
    public function findByCode(string $code): ?Auth
    {
        return Auth::code($code)->first();
    }

    /**
     * トークンの保存
     *
     * @param int $user_id
     * @param int $discord_token_id
     * @param string $access_token
     * @param string $refresh_token
     * @param Carbon $expires_in
     * @return Token
     */
    public function storeToken(
        int $user_id,
        int $discord_token_id,
        string $access_token,
        string $refresh_token,
        Carbon $expires_in
    ): Token
    {
        return Token::create([
            'user_id' => $user_id,
            'discord_token_id' => $discord_token_id,
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'expires_in' => $expires_in
        ]);
    }

    /**
     * code_verifierから計算したハッシュ値がcode_challengeと一致するかを判定
     * @param string $code_verifier
     * @param string $code_challenge
     * @return bool
     */
    public function verify(string $code_verifier, string $code_challenge): bool
    {
        $encoded = base64_encode(hash('sha256', $code_verifier, true));
        return $code_challenge === strtr(rtrim($encoded, '='), '+/', '-_');
    }

    /**
     * 認可コードの生成
     * UUIDを取ってハイフンを消したものをcodeとして扱う
     *
     * @return string
     */
    public function makeCode(): string
    {
        return str_replace('-', '', Str::uuid());
    }

    // callback

    /**
     * フロントエンドにコールバック
     * @param string $state
     * @param string $code
     * @return RedirectResponse
     */
    public function callbackApp(string $state, string $code)
    {
        $callback_url = env('FRONTEND_CALLBAC_URL');
        return redirect()->away(
            "$callback_url?state=$state&code=$code"
        );
    }
}
