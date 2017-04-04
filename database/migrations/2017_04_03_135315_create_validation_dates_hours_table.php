<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationDatesHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_dates_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->date('min_start_date')->nullable();
            $table->date('max_start_date');
            $table->date('min_end_date')->nullable();
            $table->date('max_end_date');
            $table->time('min_start_hour')->nullable();
            $table->time('max_start_hour')->nullable();
            $table->time('min_end_hour')->nullable();
            $table->time('max_end_hour')->nullable();
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
        Schema::dropIfExists('validation_dates_hours');
    }
}
