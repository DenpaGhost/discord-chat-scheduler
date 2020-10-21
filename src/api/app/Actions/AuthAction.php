<?php


namespace App\Actions;


use App\Functions\AppOAuthFunction;
use App\Functions\AuthUtility;
use App\Functions\DiscordOAuthFunction;
use App\Functions\UserFunction;
use App\Models\Discord\CurrentUser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AuthAction
{
    private AppOAuthFunction $app_auth;
    private DiscordOAuthFunction $discord_auth;
    private UserFunction $user_func;
    private AuthUtility $auth_util;

    /**
     * AuthAction constructor.
     * @param AppOAuthFunction $app_auth
     * @param DiscordOAuthFunction $discord_auth
     * @param UserFunction $user_func
     * @param AuthUtility $auth_util
     */
    public function __construct(AppOAuthFunction $app_auth, DiscordOAuthFunction $discord_auth, UserFunction $user_func, AuthUtility $auth_util)
    {
        $this->app_auth = $app_auth;
        $this->discord_auth = $discord_auth;
        $this->user_func = $user_func;
        $this->auth_util = $auth_util;
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
        $discord_state = $this->auth_util->makeState();
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
        $discord = $this->discord_auth->findByDiscordState($discord_state);
        if ($discord === null) throw new ModelNotFoundException();

        $token = $this->discord_auth->fetchAccessToken($code);
        Log::channel('single')->info($token['access_token']);

        $discord_token = $this->discord_auth->storeToken(
            $token['access_token'],
            $token['refresh_token'],
            $this->auth_util->convertExpiresIn($token['expires_in']));
        $app_code = $this->app_auth->makeCode();
        $app = $this->app_auth->storeState(
            $discord->auth_client_id,
            $discord->state,
            $app_code,
            $discord->code_challenge,
            $discord_token->id);
        return $this->app_auth->callbackApp($app->state, $app_code);
    }

    /**
     * アクセストークンの発行
     *
     * @param string $code
     * @param string $verifier
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function grantToken(string $code, string $verifier)
    {
        $state = $this->app_auth->findByCode($code);
        if ($state === null)
            throw new ModelNotFoundException();

        if (!$this->app_auth->verify($verifier, $state->code_challenge))
            throw new AuthenticationException();

        $discord_user = new CurrentUser($state->discordToken);

        $user = $this->user_func->findByDiscordId($discord_user->getId());
        if ($user === null)
            $user = $this->user_func->create($discord_user->getId());

        $access_token = $this->auth_util->makeToken();
        $refresh_token = $this->auth_util->makeToken();
        [$expires_in, $expires_in_carbon] = $this->auth_util->makeExpiresIn();

        $this->app_auth->storeToken(
            $user->id,
            $state->discord_token_id,
            $access_token,
            $refresh_token,
            $expires_in_carbon
        );

        return response()->json([
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'expires_in' => $expires_in
        ]);
    }
}
