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

    /**
     * 認証ユーザもbotも参加しているサーバだけを残す
     * @param Collection $bot_guilds
     * @param Collection $user_guilds
     * @return Collection
     */
    public function filterAvailableGuilds(Collection $bot_guilds, Collection $user_guilds)
    {
        $user_guilds_map = $user_guilds->mapWithKeys(function ($it) {
            return [$it['id'] => [
                'id' => $it['id'],
                'icon' => $this->formattingGuildIconURL($it['id'], $it['icon']),
                'name' => $it['name'],
            ]];
        });

        $bot_guilds_map = $bot_guilds->map(function ($it) {
            return $it['id'];
        });

        return $user_guilds_map->filter(function ($value, $key) use ($bot_guilds_map) {
            return $bot_guilds_map->contains($key);
        })->values();
    }

    /**
     * ギルドアイコンパスを完全なURIに変換して返す
     * アイコン未設定の場合はnull
     *
     * @param string $guild_id
     * @param string|null $guild_icon
     * @return string|null
     */
    public function formattingGuildIconURL(string $guild_id, ?string $guild_icon): ?string
    {
        return $guild_icon === null ? null : $this->formattingImageURL("icons/$guild_id/$guild_icon.png");
    }

    /**
     * CDNエンドポイントのアペンド
     * @param string $path
     * @return string
     */
    public function formattingImageURL(string $path)
    {
        return "https://cdn.discordapp.com/$path";
    }
}
