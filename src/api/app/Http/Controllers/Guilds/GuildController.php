<?php

namespace App\Http\Controllers\Guilds;

use App\Actions\Guilds\GuildAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GuildController extends Controller
{
    private GuildAction $guild_action;

    /**
     * GuildController constructor.
     * @param GuildAction $guild_action
     */
    public function __construct(GuildAction $guild_action)
    {
        $this->guild_action = $guild_action;

        $this->middleware('available-guild')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user_id = Auth::id();
        return $this->guild_action->fetchAvailableGuilds($user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->guild_action->getGuild($id);
    }
}
