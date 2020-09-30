<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AuthClient
 * @package App\Models
 *
 * @property-read string $id
 * @property-read string $client_secret
 */
class AuthClient extends Model
{
    use HasFactory;
}
