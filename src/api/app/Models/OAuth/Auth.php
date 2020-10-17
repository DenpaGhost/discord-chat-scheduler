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
 */
class Auth extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'state',
        'code',
        'code_challenge',
        'discord_oauth_state'
    ];

    public function client()
    {
        return $this->belongsTo(AuthClient::class);
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
}
