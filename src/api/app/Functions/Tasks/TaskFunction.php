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
     * タスクの新規作成
     * @param int $guild_id
     * @param int $channel_id
     * @param string $message
     * @param Carbon $executes_in
     * @param string|null $repeat
     * @return Task
     */
    public function storeTask(
        int $guild_id,
        int $channel_id,
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
            'repeat' => $repeat
        ]);
    }

    /**
     * @param string $task_uid
     * @param int $channel_id
     * @param string $message
     * @param Carbon $executes_in
     * @param string|null $repeat
     *
     * @return Task
     * @throws ModelNotFoundException
     */
    public function updateTask(
        string $task_uid,
        int $channel_id,
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
        $model->repeat = $repeat;
        $model->save();

        return $model;
    }

    /**
     * タスクの削除
     * @param string $task_uid
     */
    public function deleteTask(
        string $task_uid
    )
    {
        Task::destroy($task_uid);
    }
}
