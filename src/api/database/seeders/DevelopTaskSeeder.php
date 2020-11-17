<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DevelopTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new Carbon('2020-11-20');
        Task::create([
            'guild_id' => 660105903810281511,
            'channel_id' => 725707945387491384,
            'message' => 'テスト',
            'executes_in' => $date,
            'executes_day_of_week' => $date->dayOfWeek,
            'executes_week_of_month_number' => $date->weekOfMonth,
            'is_end_of_month' => $date->isLastOfMonth()
        ]);
    }
}
