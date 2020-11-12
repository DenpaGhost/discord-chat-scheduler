<?php


namespace App\Models\Discord;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class BotUser
{
    protected PendingRequest $http_client;

    public function __construct(string $token)
    {
        $this->http_client = Http::baseUrl('https://discord.com/api')->withHeaders([
            'Authorization' => "Bot $token"
        ]);
    }

    public function getGuilds()
    {
        return $this->http_client->get('/users/@me/guilds')->json();
    }
}
