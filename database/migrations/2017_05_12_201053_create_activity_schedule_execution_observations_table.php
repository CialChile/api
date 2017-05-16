<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityScheduleExecutionObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_schedule_execution_observations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_schedule_execution_id')->unsigned();
            $table->text('observation');
            $table->nullableTimestamps();
            $table->foreign('activity_schedule_execution_id')->references('id')->on('activity_schedule_execution')->name('activity_schedule_execution_observations_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_schedule_execution_observations');
    }
}
