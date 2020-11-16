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

    /**
     * Botの所属するギルドの取得
     * @return array|mixed
     */
    public function getGuilds()
    {
        return $this->http_client->get('/users/@me/guilds')->json();
    }

    /**
     * ギルド情報の取得
     * @param int $guild_id
     * @return array|mixed
     */
    public function getGuild(int $guild_id)
    {
        return $this->fetchJson("/guilds/$guild_id");
    }

    /**
     * チャンネルの取得
     * @param int $guild_id
     * @return array|mixed
     *
     * @see https://discord.com/developers/docs/resources/guild#create-guild-channel
     */
    public function getGuildChannels(int $guild_id)
    {
        return $this->fetchJson("/guilds/{$guild_id}/channels");
    }

    /**
     * ロールの取得
     * @param int $guild_id
     * @return array|mixed
     */
    public function getGuildRoles(int $guild_id)
    {
        return $this->fetchJson("/guilds/{$guild_id}/roles");
    }

    /**
     * 絵文字の取得
     * @param int $guild_id
     * @return array|mixed
     */
    public function getGuildEmojis(int $guild_id)
    {
        return $this->fetchJson("/guilds/{$guild_id}/emojis");
    }

    /**
     * リソースを取得してJSONデコード
     * @param string $path
     * @return array|mixed
     */
    protected function fetchJson(string $path)
    {
        return $this->http_client->get($path)->json();
    }
}
