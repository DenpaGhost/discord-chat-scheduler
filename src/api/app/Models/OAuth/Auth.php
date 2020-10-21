<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Auth
 * @package App\Models
 *
 * @property-read int $id
 * @property-read string $client_id
 * @property-read string $state
 * @property-read string $code
 * @property-read string $code_challenge
 * @property-read int $discord_token_id
 * @property-read AuthClient $client
 * @property-read DiscordToken $discordToken
 */
class Auth extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'state',
        'code',
        'code_challenge',
        'discord_token_id'
    ];

    public function client()
    {
        return $this->belongsTo(AuthClient::class, 'client_id');
    }

    public function discordToken()
    {
        return $this->belongsTo(DiscordToken::class, 'discord_token_id');
    }

    /**
     * @param Builder $query
     * @param $state
     * @return Builder
     */
    public function scopeState($query, $state)
    {
        return $query->where('state', $state);
    }

    /**
     * @param Builder $query
     * @param $code
     * @return Builder
     */
    public function scopeCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
