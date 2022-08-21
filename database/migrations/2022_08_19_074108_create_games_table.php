<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('league_id');
            $table->foreign('league_id')->references('id')->on('leagues');

            $table->foreignId('team_id_1');
            $table->foreign('team_id_1')->references('id')->on('teams');

            $table->foreignId('team_id_2');
            $table->foreign('team_id_2')->references('id')->on('teams');

            $table->timestamp('date_time');

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
        Schema::dropIfExists('games');
    }
};
