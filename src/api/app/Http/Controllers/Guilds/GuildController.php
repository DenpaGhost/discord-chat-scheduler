<?php

namespace App\Http\Controllers\Guilds;

use App\Actions\Guilds\GuildAction;
use App\Http\Controllers\Controller;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user_id = Auth::id();
        return response()->json(
            $this->guild_action->fetchAvailableGuilds($user_id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
