<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('trade_date');
            $table->bigInteger('event_id');
            $table->string('event_type');
            $table->bigInteger('team_one_id');
            $table->bigInteger('team_two_id');
            $table->text('team_one_score');
            $table->integer('team_two_score');
            $table->string('result');
            $table->string('reward');
            $table->decimal('running_total');
            $table->string('notes')->nullable();
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('trades');
    }
}
