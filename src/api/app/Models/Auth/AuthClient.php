<?php

namespace App\Models\Auth;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;

/**
 * Class AuthClient
 * @package App\Models
 *
 * @property-read string $id
 * @property-read ?string $client_secret
 */
class AuthClient extends Model
{
    use HasFactory;

    /**
     * @param Builder $query
     * @param string $id
     * @return Builder
     */
    public function scopeId($query, string $id)
    {
        return $query->where('id', $id);
    }
}
