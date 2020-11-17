<?php

namespace App\Http\Middleware\Guilds;

use App\Actions\Guilds\GuildAction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailableGuild
{
    private GuildAction $action;

    /**
     * AvailableGuild constructor.
     * @param $guild_action
     */
    public function __construct(GuildAction $guild_action)
    {
        $this->action = $guild_action;
    }


    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $guild_id = $request->route()->parameter('guild_id');

        if (!$this->action->isAvailableGuild(Auth::id(), $guild_id)) {
            return response('Not Found', 404);
        }

        return $next($request);
    }
}
