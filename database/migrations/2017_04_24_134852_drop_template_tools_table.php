<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTemplateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('template_tools');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('template_tools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->integer('assets_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->foreign('assets_id')->references('id')->on('assets');
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }
}
