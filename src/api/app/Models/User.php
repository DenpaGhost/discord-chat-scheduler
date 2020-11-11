<?php

namespace App\Models;

use App\Models\Auth\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package App\Models
 *
 * @property-read int $id
 * @property-read string $discord_id
 * @property-read Token[]|Collection $tokens
 */
class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discord_id'
    ];

    /**
     * @param Builder $query
     * @param string $discord_id
     * @return Builder
     */
    public function scopeDiscordId($query, string $discord_id)
    {
        return $query->where('discord_id', $discord_id);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class, 'user_id');
    }
}
