<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('name_template');
            $table->dropColumn('name_activity');
            $table->dropColumn('description_activity');
            $table->dropColumn('execution_estimated_time');
            $table->integer('estimated_execution_time')->after('periodicity_id');
            $table->text('description')->nullable()->after('periodicity_id');
            $table->string('name')->after('periodicity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('activity_name');
            $table->dropColumn('estimated_execution_time');
            $table->dropColumn('description');
            $table->integer('execution_estimated_time')->nullable()->after('periodicity_id');
            $table->string('description_activity')->nullable()->after('periodicity_id');
            $table->string('name_activity')->nullable()->after('periodicity_id');
            $table->string('name_template')->nullable()->after('periodicity_id');
        });
    }
}
