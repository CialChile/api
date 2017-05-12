<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTableNewVersion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('periodicities');
        Schema::dropIfExists('frequencies');
        Schema::dropIfExists('measure_units');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('validation_courses');
        Schema::dropIfExists('validation_dates_hours');
        Schema::dropIfExists('validation_operators_inspectors');
        Schema::dropIfExists('validation_supervisors');
        Schema::dropIfExists('execution_activities');
        Schema::dropIfExists('observations_activities');
        Schema::dropIfExists('observations');
        Schema::dropIfExists('activity_assets');
        Schema::dropIfExists('activities');

        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->integer('supervisor_id')->unsigned()->nullable();
            $table->integer('program_type_id')->unsigned()->index();
            $table->integer('template_id')->unsigned()->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('estimated_time')->nullable();
            $table->tinyInteger('estimated_time_unit')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('program_type_id')->references('id')->on('program_types');
            $table->foreign('template_id')->references('id')->on('templates');
            $table->nullableTimestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('activities');
    }
}
