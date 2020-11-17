<?php


namespace App\Functions\Tasks;


use App\Models\Task;
use App\Models\Tasks\TaskRepeat;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskProvideFunction
{
    /**
     * 毎年実行するタスクを取得
     * @return Task[]|Collection
     */
    public function getYearlyTasks()
    {
        $date = $this->now();

        return Task::repeat(TaskRepeat::$YEARLY)
            ->executeMonth($date->month)
            ->executeDay($date->day)
            ->executeHourAndMinute($date->hour, $date->minute)
            ->get();
    }

    /**
     * 毎月 指定週の指定曜日に実行するタスクを取得
     * @return Task[]|Collection
     */
    public function getDayOfWeekPerMonthTasks()
    {
        $date = $this->now();

        return Task::repeat(TaskRepeat::$DAY_OF_WEEK_PER_MONTH)
            ->executeDayOfWeek($date->dayOfWeek)
            ->executeWeekOfMonthNum($date->weekOfMonth)
            ->executeHourAndMinute($date->hour, $date->minute)
            ->get();
    }

    /**
     * 月末に繰り返し指定のされているタスクを取得
     * @return Task[]|Collection
     */
    public function getEndOfMonthTasks()
    {
        $date = $this->now();

        return $date->isLastOfMonth() ? Task::repeat(TaskRepeat::$END_OF_MONTH)
            ->isEndOfMonth()
            ->executeHourAndMinute($date->hour, $date->minute)
            ->get() : collect();
    }

    /**
     * 毎月実行するタスクを取得
     * @return Task[]|Collection
     */
    public function getDatePerMonthTasks()
    {
        $date = $this->now();

        return Task::repeat(TaskRepeat::$DATE_PER_MONTH)
            ->executeDay($date->day)
            ->executeHourAndMinute($date->hour, $date->minute)
            ->get();
    }

    /**
     * 毎週実行するタスクを取得
     * @return Task[]|Collection
     */
    public function getWeeklyTasks()
    {
        $date = $this->now();

        return Task::repeat(TaskRepeat::$WEEKLY)
            ->executeDayOfWeek($date->dayOfWeek)
            ->executeHourAndMinute($date->hour, $date->minute)
            ->get();
    }

    /**
     * 毎日実行するタスクを取得
     * @return Task[]|Collection
     */
    public function getDailyTasks()
    {
        $date = $this->now();

        return Task::repeat(TaskRepeat::$DAILY)
            ->executeHourAndMinute($date->hour, $date->minute)
            ->get();
    }

    /**
     * 現在日時の取得
     * @return Carbon
     */
    protected function now()
    {
        return Carbon::now()->second(0);
    }
}
