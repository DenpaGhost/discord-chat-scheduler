<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Auth
 * @package App\Models
 *
 * @property-read int $id
 * @property-read string $client_id
 * @property-read string $state
 * @property-read string $code
 * @property-read string $code_challenge
 * @property-read string $code_challenge_method
 * @property-read string $discord_oauth_state
 */
class Auth extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(AuthClient::class);
    }
}
