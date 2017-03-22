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
        Schema::create('certification_worker_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certification_id')->unsigned();
            $table->foreign('certification_id')->references('id')->on('certification');
            $table->integer('assets_id')->unsigned();
            $table->integer('worker_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
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
        Schema::dropIfExists('certification_worker_assets');
    }
}
