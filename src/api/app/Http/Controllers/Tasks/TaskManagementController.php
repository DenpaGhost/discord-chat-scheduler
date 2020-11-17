<?php

namespace App\Http\Controllers\Tasks;

use App\Actions\Tasks\TaskManagementAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskEditRequest;
use App\Http\Requests\Tasks\TaskStoreRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskManagementController extends Controller
{
    private TaskManagementAction $action;

    /**
     * TaskManagementController constructor.
     * @param TaskManagementAction $action
     */
    public function __construct(TaskManagementAction $action)
    {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $guild_id
     * @return JsonResponse
     */
    public function index(int $guild_id)
    {
        return $this->action->getGuildTasks($guild_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     * @param string $guild_id
     * @return JsonResponse
     * @throws Exception
     */
    public function store(TaskStoreRequest $request, string $guild_id)
    {
        return $this->action->storeTask($guild_id, $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param string $guild_id ミドルウェアのために存在
     * @param string $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show(string $guild_id, string $id)
    {
        return $this->action->getTaskById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskEditRequest $request
     * @param string $guild_id
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(TaskEditRequest $request, string $guild_id, string $id)
    {
        return $this->action->updateTask($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $guild_id
     * @param string $id
     * @return Application|ResponseFactory|JsonResponse|Response|void
     */
    public function destroy(string $guild_id, string $id)
    {
        return $this->action->deleteTask($id);
    }
}
