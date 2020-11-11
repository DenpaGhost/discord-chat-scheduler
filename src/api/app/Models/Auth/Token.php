<?php

namespace App\Models\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Token
 * @package App\Models
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $discord_token_id
 * @property string $access_token
 * @property string $refresh_token
 * @property string $auth_client_id
 * @property-read AuthClient $authClient
 * @property-read DiscordToken $discordToken
 * @property-read User $user
 * @property $expires_in
 */
class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'discord_token_id',
        'auth_client_id',
        'access_token',
        'refresh_token',
        'expires_in'
    ];

    protected $dates = [
        'expires_in'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authClient()
    {
        return $this->belongsTo(AuthClient::class, 'auth_client_id');
    }

    public function discordToken()
    {
        return $this->belongsTo(DiscordToken::class, 'discord_token_id');
    }

    /**
     * @param Builder $query
     * @param string $access_token
     * @return Builder
     */
    public function scopeAccessToken($query, string $access_token)
    {
        return $query->where('access_token', $access_token);
    }

    /**
     * @param Builder $query
     * @param string $refresh_token
     * @return Builder
     */
    public function scopeRefreshToken($query, string $refresh_token)
    {
        return $query->where('refresh_token', $refresh_token);
    }
}
