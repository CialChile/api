<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityScheduleExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_schedule_executions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('executed_by')->unsigned()->nullable();
            $table->integer('activity_schedule_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamp('execution_date')->nullable();
            $table->timestamp('executed_date')->nullable();
            $table->integer('duration')->nullable();
            $table->tinyInteger('duration_unit')->nullable()->comment('0: hours, 1:days, 2:weeks, 3:months');
            $table->boolean('executed')->default(0)->nullable();
            $table->nullableTimestamps();

            $table->foreign('status_id')->references('id')->on('activity_schedule_execution_status');
            $table->foreign('executed_by')->references('id')->on('users');
            $table->foreign('activity_schedule_id')->references('id')->on('activity_schedules');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_schedule_executions');
    }
}
