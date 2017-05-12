<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToActivitySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_schedules', function (Blueprint $table) {
            $table->string('program_type_slug')->after('operator_id');
            $table->string('asset_id')->after('operator_id')->nullable();
            $table->integer('day_of_month')->after('config')->nullable();
            $table->json('days')->after('config')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_schedules', function (Blueprint $table) {
            $table->dropColumn('program_type_slug');
            $table->dropColumn('day_of_month');
            $table->dropColumn('days');
            $table->dropColumn('asset_id');
        });
    }
}
