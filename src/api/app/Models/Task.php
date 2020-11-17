<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

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
 * @property $executes_day_of_week
 * @property $executes_week_of_month_number
 * @property $is_end_of_month
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

    /**
     * @param Builder $query
     * @param int $guild_id
     * @return Builder
     */
    public function scopeGuildId($query, int $guild_id)
    {
        return $query->where('guild_id', $guild_id);
    }

    /**
     * @param Builder $query
     * @param int $channel_id
     * @return Builder
     */
    public function scopeChannelId($query, int $channel_id)
    {
        return $query->where('channel_id', $channel_id);
    }
}
