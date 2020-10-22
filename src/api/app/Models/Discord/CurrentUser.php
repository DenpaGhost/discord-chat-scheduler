<?php


namespace App\Models\Discord;


use App\Functions\AuthUtility;
use App\Functions\DiscordAuthFunction;
use App\Models\Auth\DiscordToken;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CurrentUser
{
    protected PendingRequest $http_client;
    protected DiscordToken $token;
    protected ?Response $_user = null;
    protected DiscordAuthFunction $discord_auth;
    protected AuthUtility $auth_util;

    /**
     * CurrentUser constructor.
     * @param DiscordToken $token
     * @param DiscordAuthFunction $discord_auth
     * @param AuthUtility $auth_util
     */
    public function __construct(DiscordToken $token, DiscordAuthFunction $discord_auth, AuthUtility $auth_util)
    {
        $this->token = $token;
        $this->http_client = Http::baseUrl('https://discord.com/api')->withToken($this->token->access_token);

        $this->discord_auth = $discord_auth;
        $this->auth_util = $auth_util;
    }

    /**
     * {
     *     "id": "80351110224678912",
     *     "username": "Nelly",
     *     "discriminator": "1337",
     *     "avatar": "8342729096ea3675442027381ff50dfe",
     *     "verified": true,
     *     "email": "nelly@discord.com",
     *     "flags": 64,
     *     "premium_type": 1,
     *     "public_flags": 64
     * }
     * @return Response
     */
    protected function _getCurrentUser()
    {
        if (Carbon::now()->gt($this->token->expires_in->subDay())) {
            $this->refreshToken();
        }

        if ($this->_user === null) {
            $this->_user = $this->http_client->get('/users/@me');
        }
        return $this->_user;
    }

    /**
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->_getCurrentUser()['id'];
    }

    /**
     * @return string
     */
    public function getUserName(): ?string
    {
        return $this->_getCurrentUser()['username'];
    }

    /**
     */
    protected function refreshToken()
    {
        $response = $this->discord_auth->refreshAccessToken($this->token->refresh_token);
        $this->token->access_token = $response['access_token'];
        $this->token->refresh_token = $response['refresh_token'];
        $this->token->expires_in = $this->auth_util->convertExpiresIn($response['expires_in']);
        $this->token->save();
        $this->http_client = Http::baseUrl('https://discord.com/api')->withToken($this->token->access_token);
    }
}
