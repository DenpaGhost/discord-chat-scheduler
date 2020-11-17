<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('guild_id');
            $table->unsignedBigInteger('channel_id');
            $table->string('message');
            $table->dateTime('executes_in');
            $table->unsignedInteger('executes_day_of_week');
            $table->unsignedInteger('executes_week_of_month_number');
            $table->boolean('is_end_of_month');
            $table->string('repeat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
