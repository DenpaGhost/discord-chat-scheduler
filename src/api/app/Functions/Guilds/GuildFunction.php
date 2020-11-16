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
            $this->getBotUser()->getGuilds()
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
        $user_guilds_map = $this->transformGuildsForMap($user_guilds);
        $bot_guilds_map = $this->transformGuildsForIdArray($bot_guilds);

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

    /**
     * 取得したデータの変換
     * @param Collection $guilds
     * @return Collection
     */
    public function transformGuildsForMap(Collection $guilds): Collection
    {
        return $guilds->mapWithKeys(function ($it) {
            return [$it['id'] => [
                'id' => $it['id'],
                'icon' => $this->formattingGuildIconURL($it['id'], $it['icon']),
                'name' => $it['name'],
            ]];
        });
    }

    /**
     * GuildレスポンスコレクションをGuild IDのみの配列に変換
     *
     * @param Collection $guilds
     * @return Collection|int[]
     */
    public function transformGuildsForIdArray(Collection $guilds): Collection
    {
        return $guilds->map(function ($it) {
            return $it['id'];
        });
    }

    /**
     * ユーザが表示可能なギルドであるかどうか確認
     * @param int $guild_id
     * @param Collection $user_guilds
     * @param Collection $bot_guilds
     * @return bool
     */
    public function hasGuild(int $guild_id, Collection $user_guilds, Collection $bot_guilds): bool
    {
        $user_guilds_ids = $this->transformGuildsForIdArray($user_guilds);
        $bot_guilds_ids = $this->transformGuildsForIdArray($bot_guilds);

        return $user_guilds_ids->contains($guild_id) && $bot_guilds_ids->contains($guild_id);
    }

    /**
     * サーバの取得
     * @param int $guild_id
     * @return array|mixed
     */
    public function getGuild(int $guild_id)
    {
        return $this->getBotUser()->getGuild($guild_id);
    }

    /**
     * サーバーのテキストチャンネルを取得
     * @param int $guild_id
     * @return array|mixed
     */
    public function getGuildTextChannel(int $guild_id)
    {
        $channels = collect($this->getBotUser()->getGuildChannels($guild_id));

        return $channels->filter(function ($it) {
            return $it['type'] === 0;
        })->sortBy(function ($it) {
            return $it['position'];
        });
    }

    protected function getBotUser()
    {
        return new BotUser(env('DISCORD_BOT_TOKEN'));
    }
}
