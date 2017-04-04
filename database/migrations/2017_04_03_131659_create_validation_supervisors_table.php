<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationSupervisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_supervisors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->integer('speciality_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->integer('years_experience')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->foreign('speciality_id')->references('id')->on('specialties');
            $table->foreign('position_id')->references('id')->on('positions');
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
        Schema::dropIfExists('validation_supervisors');
    }
}
