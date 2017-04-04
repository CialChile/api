<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned()->index();
            $table->integer('assets_id')->unsigned()->index();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('assets_id')->references('id')->on('assets');
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
        Schema::dropIfExists('activity_assets');
    }
}
