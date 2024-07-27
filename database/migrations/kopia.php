<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clank_games', function (Blueprint $table) {
            $table->id();
            $table ->timestamps();
        });

        Schema::create('clank_games_results', function (Blueprint $table) {
            $table->id(); // ID wiersza
            $table->integer('game_id'); //ID gry
            $table->foreignId('player_id')->constrained('clank_users'); //ID gracza
            $table->string('player_name'); //Imię gracza
            $table->integer('status');
            $table->integer('gold')->nullable();
            $table->integer('tokens')->nullable();
            $table->boolean('art5')->nullable();
            $table->boolean('art7')->nullable();
            $table->boolean('art10')->nullable();
            $table->boolean('art12')->nullable();
            $table->boolean('art15')->nullable();
            $table->boolean('art17')->nullable();
            $table->boolean('art20')->nullable();
            $table->boolean('art25')->nullable();
            $table->boolean('art30')->nullable();
            $table->integer('total_points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clank_games_results');
    }
};
