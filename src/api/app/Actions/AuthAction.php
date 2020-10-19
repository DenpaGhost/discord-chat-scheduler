<?php


namespace App\Actions;


use App\Functions\AppOAuthFunction;
use App\Functions\DiscordOAuthFunction;
use App\Models\OAuth\DiscordAuth;

class AuthAction
{
    private AppOAuthFunction $app_auth;
    private DiscordOAuthFunction $discord_auth;

    /**
     * AuthAction constructor.
     * @param AppOAuthFunction $app_auth
     * @param DiscordOAuthFunction $discord_auth
     */
    public function __construct(AppOAuthFunction $app_auth, DiscordOAuthFunction $discord_auth)
    {
        $this->app_auth = $app_auth;
        $this->discord_auth = $discord_auth;
    }

    public function startDiscordAuthorizing(string $auth_client_id, string $state, string $code_challenge)
    {
        $discord_state = $this->discord_auth->makeState();
        $auth = $this->discord_auth->storeState($auth_client_id, $state, $discord_state, $code_challenge);
        $this->discord_auth->redirectOAuthForm($auth->discord_oauth_state);
    }

    public function makeCode(string $discord_state, string $code)
    {
        $discord = $this->discord_auth->findByState($discord_state);
        $token = $this->discord_auth->fetchAccessToken($code);
        $discord_token = $this->discord_auth->storeToken(
            $token['access_token'], $token['refresh_token'], $token['expires_in']);
        $app_code = $this->app_auth->makeCode();
        $app = $this->app_auth->storeState(
            $discord->auth_client_id, $discord->state, $app_code, $discord->code_challenge, $discord_token->id);
        $this->app_auth->callbackApp($app->state, $app_code);
    }
}
