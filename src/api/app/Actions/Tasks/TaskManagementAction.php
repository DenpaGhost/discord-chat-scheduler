<?php


namespace App\Actions\Tasks;


use App\Functions\Tasks\TaskFunction;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskManagementAction
{
    private TaskFunction $task_func;

    /**
     * TaskManagementAction constructor.
     * @param TaskFunction $task_func
     */
    public function __construct(TaskFunction $task_func)
    {
        $this->task_func = $task_func;
    }

    /**
     * サーバーに設定されているすべてのタスクを返す
     * @param string $guild_id
     * @return JsonResponse
     */
    public function getGuildTasks(string $guild_id)
    {
        return response()->json(
            $this->task_func->getTasksByGuildId($guild_id)
        );
    }

    /**
     * @param string $task_id
     * @return JsonResponse
     */
    public function getTaskById(string $task_id)
    {
        return response()->json(
            $this->task_func->getTaskById($task_id)
        );
    }

    /**
     * @param string $guild_id
     * @param array $forms
     * @return Application|ResponseFactory|JsonResponse|Response
     * @throws Exception
     */
    public function storeTask(string $guild_id, array $forms)
    {
        if (!$this->task_func->isValidRepeatString($forms['repeat'])) {
            return response('repeat is unprocessable', 422);
        }

        return response()->json(
            $this->task_func->storeTask(
                $guild_id,
                $forms['channel_id'],
                $forms['message'],
                new Carbon($forms['executes_in']),
                empty($forms['repeat']) ? null : $forms['repeat']
            )
        );
    }

    /**
     * @param string $task_id
     * @param array $forms
     * @return Application|ResponseFactory|JsonResponse|Response
     * @throws Exception
     */
    public function updateTask(string $task_id, array $forms)
    {
        if (!$this->task_func->isValidRepeatString($forms['repeat'])) {
            return response('repeat is unprocessable', 422);
        }

        return response()->json(
            $this->task_func->updateTask(
                $task_id,
                $forms['channel_id'],
                $forms['message'],
                new Carbon($forms['executes_in']),
                empty($forms['repeat']) ? null : $forms['repeat']
            )
        );
    }

    /**
     * @param string $task_id
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function deleteTask(string $task_id)
    {
        if ($this->task_func->deleteTask($task_id)) {
            return response(null, 200);
        } else {
            return response(null, 404);
        }
    }
}
