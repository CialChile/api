<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->integer('operator_id')->unsigned();
            $table->string('frequency');
            $table->integer('periodicity')->unsigned();
            $table->json('config')->nullable();
            $table->time('start_time');
            $table->integer('estimated_duration');
            $table->tinyInteger('estimated_duration_unit')->comment('0: hours, 1:days, 2:weeks, 3:months');
            $table->nullableTimestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('operator_id')->references('id')->on('users');
        });

        Schema::disableForeignKeyConstraints();
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->after('company_id');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->after('company_id');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        Schema::table('workers', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->after('company_id');
            $table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_schedules');
    }
}
