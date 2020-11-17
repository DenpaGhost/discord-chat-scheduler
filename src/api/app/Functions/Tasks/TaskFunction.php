<?php


namespace App\Functions\Tasks;


use App\Models\Task;
use App\Models\Tasks\TaskRepeat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class TaskFunction
{
    /**
     * @param int $guild_id
     * @return Collection|Task[]
     */
    public function getTasksByGuildId(int $guild_id)
    {
        return Task::guildId($guild_id)->get();
    }

    /**
     * @param string $task_id
     * @return Task
     * @throws ModelNotFoundException
     */
    public function getTaskById(string $task_id)
    {
        return Task::findOrFail($task_id);
    }

    /**
     * タスクの新規作成
     * @param string $guild_id
     * @param string $channel_id
     * @param string $message
     * @param Carbon $executes_in
     * @param string|null $repeat
     * @return Task
     */
    public function storeTask(
        string $guild_id,
        string $channel_id,
        string $message,
        Carbon $executes_in,
        ?string $repeat
    ): Task
    {
        return Task::create([
            'guild_id' => $guild_id,
            'channel_id' => $channel_id,
            'message' => $message,
            'executes_in' => $executes_in,
            'repeat' => $repeat,
            'executes_day_of_week' => $executes_in->dayOfWeek,
            'executes_week_of_month_number' => $executes_in->weekOfMonth,
            'is_end_of_month' => $executes_in->isLastOfMonth()
        ]);
    }

    /**
     * @param string $task_uid
     * @param string $channel_id
     * @param string $message
     * @param Carbon $executes_in
     * @param string|null $repeat
     *
     * @return Task
     */
    public function updateTask(
        string $task_uid,
        string $channel_id,
        string $message,
        Carbon $executes_in,
        ?string $repeat
    ): Task
    {
        /** @var Task $model */
        $model = Task::findOrFail($task_uid);

        $model->channel_id = $channel_id;
        $model->message = $message;
        $model->executes_in = $executes_in;
        $model->executes_day_of_week = $executes_in->dayOfWeek;
        $model->executes_week_of_month_number = $executes_in->weekOfMonth;
        $model->is_end_of_month = $executes_in->isLastOfMonth();

        $model->repeat = $repeat;
        $model->save();

        return $model;
    }

    /**
     * タスクの削除
     * @param string $task_uid
     * @return bool
     */
    public function deleteTask(
        string $task_uid
    )
    {
        return Task::destroy($task_uid) > 0;
    }

    /**
     * @param string|null $repeat
     * @return bool
     */
    public function isValidRepeatString(?string $repeat)
    {
        $repeats = collect([
            TaskRepeat::$DAILY,
            TaskRepeat::$WEEKLY,
            TaskRepeat::$DATE_PER_MONTH,
            TaskRepeat::$END_OF_MONTH,
            TaskRepeat::$DAY_OF_WEEK_PER_MONTH,
            TaskRepeat::$YEARLY
        ]);

        return empty($repeat) || $repeats->contains($repeat);
    }
}
