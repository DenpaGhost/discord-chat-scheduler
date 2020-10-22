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
            $table->foreignUuid('client_id')
                ->constrained('auth_clients')
                ->onDelete('cascade');
            $table->string('state')->unique();
            $table->string('code')->unique();
            $table->text('code_challenge');
            $table->foreignId('discord_token_id')
                ->constrained('discord_tokens')
                ->onDelete('cascade');
            $table->dateTime('expires_in');
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
