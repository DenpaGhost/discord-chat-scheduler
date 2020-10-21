<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord_auths', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->string('discord_oauth_state');
            $table->text('code_challenge');
            $table->foreignUuid('auth_client_id')->constrained('auth_clients')->onDelete('cascade');
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
        Schema::dropIfExists('discord_auths');
    }
}
