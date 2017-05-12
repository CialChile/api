<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTemplatesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('templates', function (Blueprint $table) {

            $table->dropForeign('templates_measure_unit_id_foreign');
            $table->dropForeign('templates_frequency_id_foreign');
            $table->dropForeign('templates_periodicity_id_foreign');
            $table->dropColumn(['measure_unit_id', 'frequency_id', 'periodicity_id']);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            //
        });
    }
}
