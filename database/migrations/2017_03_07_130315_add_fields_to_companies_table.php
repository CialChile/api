<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('field_id')->unsigned()->after('id');
            $table->string('fax')->after('name')->nullable();
            $table->string('telephone')->after('name')->nullable();
            $table->string('email')->after('name')->nullable();
            $table->text('address')->after('name')->nullable();
            $table->string('zip_code')->after('name')->nullable();
            $table->string('city')->after('name')->nullable();
            $table->string('state')->after('name')->nullable();
            $table->string('country')->after('name');
            $table->string('fiscal_identification')->after('name');
            $table->string('commercial_name')->after('name');

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('field_id');
            $table->dropColumn('fax');
            $table->dropColumn('telephone');
            $table->dropColumn('email');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country_id');
            $table->dropColumn('address');
            $table->dropColumn('fiscal_identification');
            $table->dropColumn('commercial_name');
            $table->dropSoftDeletes();

        });
    }
}
