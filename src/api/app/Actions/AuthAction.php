<?php


namespace App\Actions;


use App\Functions\AppOAuthFunction;
use App\Functions\DiscordOAuthFunction;
use App\Functions\UserFunction;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AuthAction
{
    private AppOAuthFunction $app_auth;
    private DiscordOAuthFunction $discord_auth;
    private UserFunction $user_func;

    /**
     * AuthAction constructor.
     * @param AppOAuthFunction $app_auth
     * @param DiscordOAuthFunction $discord_auth
     * @param UserFunction $user_func
     */
    public function __construct(AppOAuthFunction $app_auth, DiscordOAuthFunction $discord_auth, UserFunction $user_func)
    {
        $this->app_auth = $app_auth;
        $this->discord_auth = $discord_auth;
        $this->user_func = $user_func;
    }

    /**
     * Discord OAuth2.0認証を開始する
     * @param string $auth_client_id
     * @param string $state
     * @param string $code_challenge
     * @return RedirectResponse
     */
    public function startDiscordAuthorizing(string $auth_client_id, string $state, string $code_challenge)
    {
        $discord_state = $this->discord_auth->makeState();
        $auth = $this->discord_auth->storeState($auth_client_id, $state, $discord_state, $code_challenge);
        return $this->discord_auth->redirectOAuthForm($auth->discord_oauth_state);
    }

    /**
     * トークングラントコードの発行とリダイレクト
     * @param string $discord_state
     * @param string $code
     * @return RedirectResponse
     * @throws ModelNotFoundException
     */
    public function makeCode(string $discord_state, string $code)
    {
        $discord = $this->discord_auth->findByState($discord_state);
        if ($discord === null) throw new ModelNotFoundException();

        $token = $this->discord_auth->fetchAccessToken($code);
        $discord_token = $this->discord_auth->storeToken(
            $token['access_token'], $token['refresh_token'], $token['expires_in']);
        $app_code = $this->app_auth->makeCode();
        $app = $this->app_auth->storeState(
            $discord->auth_client_id, $discord->state, $app_code, $discord->code_challenge, $discord_token->id);
        return $this->app_auth->callbackApp($app->state, $app_code);
    }

    public function grantToken(string $code, string $verifier)
    {
        $state = $this->app_auth->findByCode($code);
        if ($state === null)
            throw new ModelNotFoundException();

        if (!$this->app_auth->verify($verifier, $state->code_challenge))
            throw new AuthenticationException();

        // todo discord apiからデータを取得する処理
        $user = $this->user_func->findByDiscordId('');
        if ($user === null)
            $user = $this->user_func->create('');

        $access_token = $this->app_auth->makeToken();
        $refresh_token = $this->app_auth->makeToken();
        $now = Carbon::now();
        $expires_in = $now->copy()->addWeek();
        $diff = $now->diffInSeconds($expires_in);

        $this->app_auth->storeToken(
            $user->id,
            $state->discord_token_id,
            Hash::make($access_token),
            Hash::make($refresh_token),
            $expires_in
        );

        return response()->json([
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'expires_in' => $diff
        ]);
    }
}
