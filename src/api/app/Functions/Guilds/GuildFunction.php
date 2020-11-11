<?php


namespace App\Functions\Guilds;


use App\Models\Discord\BotUser;

class GuildFunction
{
    public function fetchBotUserGuilds()
    {
        (new BotUser(env('DISCORD_BOT_TOKEN')))->getGuilds();
    }
}
