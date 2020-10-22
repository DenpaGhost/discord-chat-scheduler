<?php


namespace App\Actions;


use App\Functions\AppOAuthFunction;
use App\Functions\AuthUtility;
use App\Functions\DiscordOAuthFunction;
use App\Functions\UserFunction;
use App\Models\Discord\CurrentUser;
use Carbon\Carbon;
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
    public function __construct(
        AppOAuthFunction $app_auth,
        DiscordOAuthFunction $discord_auth,
        UserFunction $user_func,
        AuthUtility $auth_util)
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
        $discord_token = $this->discord_auth->findByAccessToken($token['access_token']);
        if ($discord_token === null) {
            $discord_token = $this->discord_auth->storeToken(
                $token['access_token'],
                $token['refresh_token'],
                $this->auth_util->convertExpiresIn($token['expires_in']));
        }

        $app_code = $this->app_auth->makeCode();
        [, $expires_in] = $this->auth_util->makeCodeExpiresIn();

        Log::channel('single')->info($expires_in);

        $app = $this->app_auth->storeState(
            $discord->auth_client_id,
            $discord->state,
            $app_code,
            $discord->code_challenge,
            $discord_token->id,
            $expires_in);

        $this->discord_auth->deleteState($discord->id);

        return $this->app_auth->callbackApp($app->state, $app_code);
    }

    /**
     * Authクライアントの存在確認
     * @param string $id
     */
    public function validateAuthClientId(string $id)
    {
        if (!$this->app_auth->isClientExistById($id))
            throw new ModelNotFoundException();
    }

    /**
     * アクセストークンの発行
     *
     * @param string $auth_client_id
     * @param string $code
     * @param string $verifier
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function grantToken(string $auth_client_id, string $code, string $verifier)
    {
        $state = $this->app_auth->findAuthByCode($code);
        if ($state === null) {
            throw new ModelNotFoundException();
        }

        if ($state->client_id !== $auth_client_id) {
            throw new AuthenticationException();
        }

        if (!$this->app_auth->verify($verifier, $state->code_challenge)) {
            $this->app_auth->deleteState($state->id);
            throw new AuthenticationException();
        }

        if ($state->expires_in->lt(Carbon::now())) {
            $this->app_auth->deleteState($state->id);
            throw new AuthenticationException();
        }

        $discord_user = new CurrentUser($state->discordToken, $this->discord_auth, $this->auth_util);

        $user = $this->user_func->findByDiscordId($discord_user->getId());
        if ($user === null)
            $user = $this->user_func->create($discord_user->getId());

        $access_token = $this->auth_util->makeToken();
        $refresh_token = $this->auth_util->makeToken();
        [$expires_in, $expires_in_carbon] = $this->auth_util->makeTokenExpiresIn();

        $this->app_auth->storeToken(
            $user->id,
            $state->discord_token_id,
            $auth_client_id,
            $access_token,
            $refresh_token,
            $expires_in_carbon
        );

        $this->app_auth->deleteState($state->id);

        return response()->json([
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'expires_in' => $expires_in
        ]);
    }

    /**
     * @param string $auth_client_id
     * @param string $refresh_token
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function refreshToken(string $auth_client_id, string $refresh_token)
    {
        $token = $this->app_auth->findTokenByRefreshToken($refresh_token);
        if ($token->auth_client_id !== $auth_client_id) {
            throw new AuthenticationException();
        }

        $access_token = $this->auth_util->makeToken();
        $new_refresh_token = $this->auth_util->makeToken();
        [$expires_in, $expires_in_carbon] = $this->auth_util->makeTokenExpiresIn();

        $token->access_token = $access_token;
        $token->refresh_token = $new_refresh_token;
        $token->expires_in = $expires_in_carbon;

        return response()->json([
            'access_token' => $access_token,
            'refresh_token' => $new_refresh_token,
            'expires_in' => $expires_in
        ]);
    }
}
