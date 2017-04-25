<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable()->index();
            $table->integer('template_type_id')->unsigned()->nullable();
            $table->integer('program_type_id')->unsigned()->nullable();
            $table->integer('measure_unit_id')->unsigned()->nullable();
            $table->integer('frequency_id')->unsigned()->nullable();
            $table->integer('periodicity_id')->unsigned()->nullable();
            $table->string('name_template')->nullable();
            $table->string('name_activity')->nullable();
            $table->string('description_activity')->nullable();
            $table->integer('execution_estimated_time')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('template_type_id')->references('id')->on('template_types');
            $table->foreign('program_type_id')->references('id')->on('program_types');
            $table->foreign('measure_unit_id')->references('id')->on('measure_units');
            $table->foreign('frequency_id')->references('id')->on('frequencies');
            $table->foreign('periodicity_id')->references('id')->on('periodicities');
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
        Schema::dropIfExists('templates');
    }
}
