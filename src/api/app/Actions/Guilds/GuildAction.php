<?php


namespace App\Actions\Guilds;


use App\Functions\Auth\AuthUtility;
use App\Functions\Auth\DiscordAuthFunction;
use App\Functions\UserFunction;
use App\Models\Discord\CurrentUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GuildAction
{
    private UserFunction $user_func;
    private DiscordAuthFunction $discord_auth;
    private AuthUtility $auth_util;

    /**
     * GuildAction constructor.
     * @param UserFunction $user_func
     * @param DiscordAuthFunction $discord_auth
     * @param AuthUtility $auth_util
     */
    public function __construct(UserFunction $user_func, DiscordAuthFunction $discord_auth, AuthUtility $auth_util)
    {
        $this->user_func = $user_func;
        $this->discord_auth = $discord_auth;
        $this->auth_util = $auth_util;
    }

    public function fetchAvailableGuilds(int $user_id)
    {
        $discord_token = $this->user_func->getDiscordToken($user_id);

        if ($discord_token === null) {
            throw new ModelNotFoundException();
        }

        $current_user = new CurrentUser(
            $discord_token, $this->discord_auth, $this->auth_util);

        return $current_user->getGuilds()->json();
    }
}
