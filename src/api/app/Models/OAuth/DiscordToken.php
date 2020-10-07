<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DiscordToken
 * @package App\Models
 *
 * @property-read int $id
 * @property-read int $token_id
 * @property string $access_token
 * @property string $refresh_token
 * @property $expires_in
 */
class DiscordToken extends Model
{
    use HasFactory;

    public function token()
    {
        return $this->belongsTo(Token::class);
    }
}
