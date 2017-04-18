<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMorphsColumnsToCertificationsWorkersAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certifications_workers_assets', function (Blueprint $table) {
            $table->dropColumn('assets_id');
            $table->dropColumn('worker_id');
            $table->morphs('certificable', 'certificable_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certifications_workers_assets', function (Blueprint $table) {
            $table->integer('assets_id')->after('id')->unsigned();
            $table->integer('worker_id')->after('id')->unsigned();
            $table->dropColumn('certificable_id');
            $table->dropColumn('certificable_type');

        });
    }
}
