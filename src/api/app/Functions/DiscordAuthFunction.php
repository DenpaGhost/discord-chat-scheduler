<?php

namespace App\Functions;

use App\Models\Auth\DiscordAuth;
use App\Models\Auth\DiscordToken;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class DiscordOAuthFunction
 *
 * Discord Authorization Functions
 *
 * @package App\Functions
 */
class DiscordAuthFunction
{
    // store information to our database

    /**
     * Discordで認可処理が開始されている情報を保存
     * @param string $state
     * @param string $discord_oauth_state
     * @param string $code_challenge
     * @param string $auth_client_id
     * @return DiscordAuth
     */
    public function storeState(
        string $auth_client_id,
        string $state,
        string $discord_oauth_state,
        string $code_challenge
    ): DiscordAuth
    {
        return DiscordAuth::create([
            'state' => $state,
            'discord_oauth_state' => $discord_oauth_state,
            'code_challenge' => $code_challenge,
            'auth_client_id' => $auth_client_id
        ]);
    }

    /**
     * Discordで認可処理が開始されている情報をstate検索
     * @param $state
     * @return DiscordAuth|null
     */
    public function findByDiscordState($state): ?DiscordAuth
    {
        return DiscordAuth::discordState($state)->first();
    }

    /**
     * @param $access_token
     * @return DiscordAuth|null
     */
    public function findByAccessToken($access_token): ?DiscordToken
    {
        return DiscordToken::accessToken($access_token)->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteState(int $id): bool
    {
        return DiscordAuth::destroy($id);
    }

    /**
     * トークンを保存
     * @param string $access_token
     * @param string $refresh_token
     * @param Carbon $expires_in
     * @return DiscordToken
     */
    public function storeToken(
        string $access_token,
        string $refresh_token,
        Carbon $expires_in
    ): DiscordToken
    {
        return DiscordToken::create([
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'expires_in' => $expires_in
        ]);
    }

    // request to discord

    public function redirectOAuthForm(string $state)
    {
        $client_id = env('DISCORD_CLIENT_ID');
        $redirect_uri = urlencode(env('DISCORD_REDIRECT'));
        return redirect()->away(
            "https://discord.com/api/oauth2/authorize?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=identify&state=$state"
        );
    }

    /**
     * 認可コードグラント
     * @param string $code
     * @return Response
     *
     * ex:
     * {
     *     "access_token": "6qrZcUqja7812RVdnEKjpzOL4CvHBFG",
     *     "token_type": "Bearer",
     *     "expires_in": 604800,
     *     "refresh_token": "D43f5y0ahjqew82jZ4NViEr2YafMKhue",
     *     "scope": "identify"
     * }
     */
    public function fetchAccessToken(string $code): Response
    {
        $client_id = env('DISCORD_CLIENT_ID');
        $client_secret = env('DISCORD_CLIENT_SECRET');
        $redirect_uri = env('DISCORD_REDIRECT');

        return Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'scope' => 'identify'
        ]);
    }

    /**
     * アクセストークンの更新
     * @param string $refresh_token
     * @return Response
     *
     * ex:
     * {
     *     "access_token": "6qrZcUqja7812RVdnEKjpzOL4CvHBFG",
     *     "token_type": "Bearer",
     *     "expires_in": 604800,
     *     "refresh_token": "D43f5y0ahjqew82jZ4NViEr2YafMKhue",
     *     "scope": "identify"
     * }
     */
    public function refreshAccessToken(string $refresh_token)
    {
        $client_id = env('DISCORD_CLIENT_ID');
        $client_secret = env('DISCORD_CLIENT_SECRET');
        $redirect_uri = env('DISCORD_REDIRECT');

        return Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'redirect_uri' => $redirect_uri,
            'scope' => 'identify'
        ]);
    }
}
