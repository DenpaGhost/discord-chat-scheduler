<?php


namespace App\Functions\Auth;

use App\Models\Auth\Auth;
use App\Models\Auth\AuthClient;
use App\Models\Auth\Token;
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
class AppAuthFunction
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
     * @param Carbon $expires_in
     * @return Auth
     */
    public function storeState(
        string $client_id,
        string $state,
        string $code,
        string $code_challenge,
        string $discord_token_id,
        Carbon $expires_in
    ): Auth
    {
        return Auth::create([
            'client_id' => $client_id,
            'state' => $state,
            'code' => $code,
            'code_challenge' => $code_challenge,
            'discord_token_id' => $discord_token_id,
            'expires_in' => $expires_in
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteState(int $id): bool
    {
        return Auth::destroy($id);
    }

    /**
     * stateから認可待ちデータの取得
     *
     * @param string $state
     * @return Auth|null
     */
    public function findAuthByState(string $state): ?Auth
    {
        return Auth::state($state)->first();
    }

    /**
     * codeから認可待ちデータの取得
     *
     * @param string $code
     * @return Auth|null
     */
    public function findAuthByCode(string $code): ?Auth
    {
        return Auth::code($code)->first();
    }

    /**
     * Authクライアントの取得
     * @param string $id
     * @return AuthClient|null
     */
    public function findClientById(string $id): ?AuthClient
    {
        return AuthClient::id($id)->first();
    }

    /**
     * Authクライアントの存在確認
     * @param string $id
     * @return bool
     */
    public function isClientExistById(string $id): bool
    {
        return $this->findClientById($id) !== null;
    }

    /**
     * トークンの保存
     *
     * @param int $user_id
     * @param int $discord_token_id
     * @param string $auth_client_id
     * @param string $access_token
     * @param string $refresh_token
     * @param Carbon $expires_in
     * @return Token
     */
    public function storeToken(
        int $user_id,
        int $discord_token_id,
        string $auth_client_id,
        string $access_token,
        string $refresh_token,
        Carbon $expires_in
    ): Token
    {
        return Token::create([
            'user_id' => $user_id,
            'discord_token_id' => $discord_token_id,
            'auth_client_id' => $auth_client_id,
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'expires_in' => $expires_in
        ]);
    }

    /**
     * @param string $refresh_token
     * @return Token|null
     */
    public function findTokenByRefreshToken(string $refresh_token): ?Token
    {
        return Token::refreshToken($refresh_token)->first();
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
