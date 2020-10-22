<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class DiscordToken
 * @package App\Models
 *
 * @property-read int $id
 * @property string $access_token
 * @property string $refresh_token
 * @property $expires_in
 * @property-read $is_expires
 */
class DiscordToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'refresh_token',
        'expires_in'
    ];

    protected $dates = [
        'expires_in'
    ];

    protected $appends = ['is_expires'];

    public function token()
    {
        return $this->hasOne(Token::class);
    }

    public function getIsExpiresAttributes()
    {
        $date = new Carbon($this->expires_in);
        return $date->lt(Carbon::now());
    }

    /**
     * @param Builder $query
     * @param string $token
     * @return Builder
     */
    public function scopeAccessToken($query, $token)
    {
        return $query->where('access_token', $token);
    }
}
