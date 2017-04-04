<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutionActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('execution_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->integer('execution_worker_supervisor_id')->unsigned();
            $table->integer('execution_worker_ope_ins_id')->unsigned();
            $table->date('execution_start_date');
            $table->date('execution_end_date');
            $table->time('execution_start_time');
            $table->time('execution_end_time');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('execution_worker_supervisor_id')->references('id')->on('workers');
            $table->foreign('execution_worker_ope_ins_id')->references('id')->on('workers');
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
        Schema::dropIfExists('execution_activities');
    }
}
