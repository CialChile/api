<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAssetsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign('assets_sub_category_id_foreign');
            $table->dropForeign('assets_model_id_foreign');
            $table->dropIndex('assets_sub_category_id_foreign');
            $table->dropIndex('assets_model_id_foreign');
        });

        Schema::table('assets', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            $table->dropColumn('image');
            DB::statement('ALTER TABLE assets MODIFY tag_rfid VARCHAR(200) ');
            DB::statement('ALTER TABLE assets MODIFY sub_category_id  INT(10) UNSIGNED ');
            DB::statement('ALTER TABLE assets MODIFY model_id  INT(10) UNSIGNED');
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->foreign('model_id')->references('id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('image')->after('serial');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign('assets_sub_category_id_foreign');
            $table->dropForeign('assets_model_id_foreign');
            $table->dropIndex('assets_sub_category_id_foreign');
            $table->dropIndex('assets_model_id_foreign');
        });

        Schema::table('assets', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            DB::statement('ALTER TABLE assets MODIFY tag_rfid VARCHAR(200) NOT NULL');
            DB::statement('ALTER TABLE assets MODIFY sub_category_id  INT(10) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE assets MODIFY model_id  INT(10) UNSIGNED NOT NULL');
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->foreign('model_id')->references('id')->on('models');
        });


    }
}
