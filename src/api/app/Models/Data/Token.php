<?php


namespace App\Models\Data;


class Token
{
    public string $access_token, $refresh_token;
    public int $expires_in;
}
