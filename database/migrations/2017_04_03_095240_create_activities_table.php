<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->integer('program_type_id')->unsigned()->index();
            $table->integer('measure_unit_id')->unsigned()->nullable();
            $table->integer('template_id')->unsigned()->index();
            $table->integer('number');
            $table->string('name');
            $table->string('description')->nullable();
            $table->json('process_type')->nullable();
            $table->integer('stimated_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
            $table->boolean('validity')->default(1);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('program_type_id')->references('id')->on('program_types');
            $table->foreign('measure_unit_id')->references('id')->on('measure_units');
            $table->foreign('template_id')->references('id')->on('templates');
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
        Schema::dropIfExists('activities');
    }
}
