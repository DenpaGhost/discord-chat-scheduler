<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @property-read int $id
 * @property-read string $discord_id
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
}
