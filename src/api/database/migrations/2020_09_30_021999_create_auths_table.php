<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auths', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('client_id')->constrained('auth_clients')->onDelete('cascade');;
            $table->string('state')->unique();
            $table->string('code')->unique();
            $table->string('code_challenge');
            $table->string('code_challenge_method');
            $table->string('discord_oauth_state')->unique();
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
        Schema::dropIfExists('auths');
    }
}
