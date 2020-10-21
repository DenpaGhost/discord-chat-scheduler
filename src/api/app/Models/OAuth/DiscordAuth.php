<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class DiscordAuth
 * @package App\Models\OAuth
 *
 * @property-read int $id
 * @property-read string $state
 * @property-read string $discord_oauth_state
 * @property-read string $code_challenge
 * @property-read string $auth_client_id
 * @property-read $created_at
 * @property-read $updated_at
 */
class DiscordAuth extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'discord_oauth_state',
        'code_challenge',
        'auth_client_id'
    ];

    /**
     * @param Builder $query
     * @param string $state
     * @return Builder
     */
    public function scopeState($query, $state)
    {
        return $query->where('state', $state);
    }

    /**
     * @param Builder $query
     * @param string $state
     * @return Builder
     */
    public function scopeDiscordState($query, string $state)
    {
        return $query->where('discord_oauth_state', $state);
    }

    /**
     * @param Builder $query
     * @param string $state
     * @return Builder
     */
    public function scopeDiscordOAuthState($query, $state)
    {
        return $query->where('discord_oauth_state', $state);
    }
}
