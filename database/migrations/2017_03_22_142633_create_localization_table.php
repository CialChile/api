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
        Schema::create('localization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assets_id')->unsigned();
            $table->foreign('assets_id')->references('id')->on('assets');
            $table->date('location_date');
            $table->timestamps();
            $table->softDeletes();

        });
        DB::statement('ALTER TABLE localization ADD location point');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localization');
    }
}
