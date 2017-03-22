<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assets_id')->unsigned();
            $table->foreign('assets_id')->references('id')->on('assets');
            $table->date('location_date')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();

        });
        DB::statement('ALTER TABLE localizations ADD location point after location_date');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localizations');
    }
}
