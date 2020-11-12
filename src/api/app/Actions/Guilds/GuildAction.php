<?php


namespace App\Actions\Guilds;


use App\Functions\Auth\AuthUtility;
use App\Functions\Auth\DiscordAuthFunction;
use App\Functions\Guilds\GuildFunction;
use App\Functions\UserFunction;
use App\Models\Auth\DiscordToken;
use App\Models\Discord\CurrentUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GuildAction
{
    private UserFunction $user_func;
    private GuildFunction $guild_func;
    private DiscordAuthFunction $discord_auth;
    private AuthUtility $auth_util;

    /**
     * GuildAction constructor.
     * @param UserFunction $user_func
     * @param GuildFunction $guild_func
     * @param DiscordAuthFunction $discord_auth
     * @param AuthUtility $auth_util
     */
    public function __construct(UserFunction $user_func, GuildFunction $guild_func, DiscordAuthFunction $discord_auth, AuthUtility $auth_util)
    {
        $this->user_func = $user_func;
        $this->guild_func = $guild_func;
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

        $user_guilds = collect($current_user->getGuilds()->json());
        $bot_guilds = $this->guild_func->fetchBotUserGuilds();


        return response()->json([
            'user_guilds' => $user_guilds,
            'bot_guilds' => $bot_guilds
        ]);
    }

    protected function getCurrentUser(DiscordToken $discord_token)
    {
        return new CurrentUser(
            $discord_token, $this->discord_auth, $this->auth_util);
    }
}
