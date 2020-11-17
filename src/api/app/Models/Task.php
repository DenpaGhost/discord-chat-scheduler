<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 * @package App\Models
 *
 * @property-read string $id
 * @property-read int $user_id
 * @property int $guild_id
 * @property int $channel_id
 * @property string $message
 * @property $executes_in
 * @property ?string $repeat (daily, weekly, date_per_month, day_of_week_per_month, yearly)
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'guild_id',
        'channel_id',
        'message',
        'executes_in',
        'repeat'
    ];

    /**
     * リレーション
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
