<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodicitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodicities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->integer('times');
            $table->string('description')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('periodicities');
    }
}
