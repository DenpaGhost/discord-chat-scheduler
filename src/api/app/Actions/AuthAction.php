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

    public function storeAuth(string $state, string $code_challenge): DiscordAuth
    {
        $discord_state = $this->discord_auth->makeState();
        return $this->discord_auth->storeState($state, $discord_state, $code_challenge);
    }

    public function makeCode(string $discord_state, string $code)
    {
        $this->discord_auth->findByState($discord_state);
        $token = $this->discord_auth->fetchAccessToken($code);

        $this->app_auth->storeState();
    }
}
