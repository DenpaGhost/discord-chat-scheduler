<?php


namespace App\Functions\Guilds;


use App\Models\Discord\BotUser;
use Illuminate\Support\Collection;

class GuildFunction
{
    /**
     * @return Collection
     */
    public function fetchBotUserGuilds()
    {
        return collect(
            (new BotUser(env('DISCORD_BOT_TOKEN')))->getGuilds()
        );
    }
}
