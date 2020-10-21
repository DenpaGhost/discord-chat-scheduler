<?php


namespace App\Functions;


use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthUtility
{
    /**
     * 有効期限の秒数表示をCarbonに変換
     * @param int $expires_in_seconds
     * @return Carbon
     */
    public function convertExpiresIn(int $expires_in_seconds): Carbon
    {
        return Carbon::now()->addSeconds($expires_in_seconds);
    }

    /**
     * @return array [int, Carbon]
     */
    public function makeExpiresIn()
    {
        $now = Carbon::now();
        $week_ago = $now->copy()->addWeek();
        return [$now->diffInSeconds($week_ago), $week_ago];
    }

    /**
     * stateの生成
     * @return string
     */
    public function makeState(): string
    {
        return Str::random(40);
    }

    /**
     * @return string
     */
    public function makeToken(): string
    {
        return Str::random(127);
    }
}
