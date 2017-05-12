<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityIdToActivityMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_materials', function (Blueprint $table) {
            $table->integer('activity_id')->unsigned()->after('id');
            $table->foreign('activity_id')->references('id')->on('activities');
        });

        Schema::table('activity_procedures', function (Blueprint $table) {
            $table->integer('activity_id')->unsigned()->after('id');
            $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acrivity_materials', function (Blueprint $table) {
            //
        });
    }
}
