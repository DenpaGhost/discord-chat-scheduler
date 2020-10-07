<?php

namespace App\Models\OAuth;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * @package App\Models
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property string $access_token
 * @property string $refresh_token
 * @property $expires_in
 */
class Token extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
