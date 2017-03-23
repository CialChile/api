<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToAssetsConfigsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->index();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->index();
        });


        Schema::table('certification_types', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->index();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->index();
        });


        Schema::table('institutes', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->index();
        });


        Schema::table('status', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->index();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('certification_types', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('institutes', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('status', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
