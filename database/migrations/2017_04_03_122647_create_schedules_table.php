<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('activity_assets_id')->unsigned();
                $table->integer('program_id')->unsigned();
                $table->integer('worker_supervisor_id')->unsigned();
                $table->integer('worker_ope_ins_id')->unsigned();
                $table->foreign('activity_assets_id')->references('id')->on('activity_assets');
                $table->foreign('program_id')->references('id')->on('programs');
                $table->foreign('worker_supervisor_id')->references('id')->on('workers');
                $table->foreign('worker_ope_ins_id')->references('id')->on('workers');
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
        Schema::dropIfExists('schedules');
    }
}
