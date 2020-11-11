<?php


namespace App\Functions;


use App\Models\Auth\DiscordToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserFunction
{
    /**
     * Discord IDからユーザを取得
     * @param string $discord_id
     * @return ?User
     */
    public function findByDiscordId(string $discord_id): ?User
    {
        return User::discordId($discord_id)->first();
    }

    /**
     * ユーザの作成
     * @param string $discord_id
     * @return User
     */
    public function create(string $discord_id): User
    {
        return User::create([
            'discord_id' => $discord_id
        ]);
    }

    /**
     * ユーザの認証
     * これを通すことでLaravelのAuth Facadeを使えていい感じになる
     *
     * @param int $user_id
     * @return bool
     */
    public function auth(int $user_id)
    {
        return Auth::onceUsingId($user_id);
    }

    /**
     * @param int $user_id
     * @return DiscordToken|null
     */
    public function getDiscordToken(int $user_id): ?DiscordToken
    {
        return DiscordToken::isExpires(false)->userId($user_id)->first();
    }
}
