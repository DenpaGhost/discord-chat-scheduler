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

    /**
     * @param Builder $query
     * @param string $repeat
     * @return Builder
     */
    public function scopeRepeat($query, string $repeat)
    {
        return $query->where('repeat', $repeat);
    }

    /**
     * @param Builder $query
     * @param int $month
     * @return Builder
     */
    public function scopeExecuteMonth($query, int $month)
    {
        return $query->whereMonth('executes_in', $month);
    }

    /**
     * @param Builder $query
     * @param int $day
     * @return Builder
     */
    public function scopeExecuteDay($query, int $day)
    {
        return $query->whereDay('executes_in', $day);
    }

    /**
     * @param Builder $query
     * @param int $week_of_month_num 1~5
     * @return Builder
     */
    public function scopeExecuteWeekOfMonthNum($query, int $week_of_month_num)
    {
        return $query->where('executes_week_of_month_number', $week_of_month_num);
    }

    /**
     * @param Builder $query
     * @param int $day_of_week 0~6
     * @return Builder
     */
    public function scopeExecuteDayOfWeek($query, int $day_of_week)
    {
        return $query->where('executes_day_of_week', $day_of_week);
    }

    /**
     * @param Builder $query
     * @param bool $is_end_of_month
     * @return Builder
     */
    public function scopeIsEndOfMonth($query, bool $is_end_of_month = true)
    {
        return $query->where('is_end_of_month', $is_end_of_month);
    }

    /**
     * @param Builder $query
     * @param int $hour
     * @param int $minute
     * @return Builder
     */
    public function scopeExecuteHourAndMinute($query, int $hour, int $minute)
    {
        return $query->whereTime('executes_in', '>', "$hour:$minute:00")
            ->whereTime('executes_in', '<', "$hour:$minute:59");
    }
}
