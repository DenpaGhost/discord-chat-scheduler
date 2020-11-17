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
        Task::create([
            'guild_id' => 660105903810281511,
            'channel_id' => 725707945387491384,
            'message' => 'テスト',
            'executes_in' => new Carbon('2020-11-20')
        ]);
    }
}
