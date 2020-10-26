<?php


namespace App\Models\Data;


use Carbon\Carbon;

class Task
{
    public string $uuid, $message, $handle_rate;
    public Carbon $handle_at;
}
