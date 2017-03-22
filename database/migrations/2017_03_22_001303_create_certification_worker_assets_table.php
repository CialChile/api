<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationWorkerAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications_workers_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certification_id')->unsigned();
            $table->integer('assets_id')->unsigned();
            $table->integer('worker_id')->unsigned();
            $table->foreign('certification_id')->references('id')->on('certifications');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('certifications_workers_assets');
    }
}
