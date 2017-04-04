<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservationsActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('observation_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->foreign('observation_id')->references('id')->on('observations');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observations_activities');
    }
}
