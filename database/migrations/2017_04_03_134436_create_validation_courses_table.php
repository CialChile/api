<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_courses', function (Blueprint $table) {
            $table->integer('validation_supervisor_id')->unsigned();
            $table->integer('validation_operator_inspector_id')->unsigned();
            $table->integer('certification_id')->unsigned();
            $table->foreign('validation_supervisor_id')->references('id')->on('validation_supervisors');
            $table->foreign('validation_operator_inspector_id')->references('id')->on('validation_operators_inspectors');
            $table->foreign('certification_id')->references('id')->on('certifications');
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
        Schema::dropIfExists('validation_courses');
    }
}
