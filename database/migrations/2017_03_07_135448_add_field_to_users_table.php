<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('company_admin')->after('active')->default(0);
            $table->text('medical_information')->after('last_name')->nullable();
            $table->text('emergency_contact')->after('last_name')->nullable();
            $table->string('emergency_telephone')->after('last_name')->nullable();
            $table->string('telephone')->after('last_name')->nullable();
            $table->string('city')->after('last_name')->nullable();
            $table->string('state')->after('last_name')->nullable();
            $table->string('country')->after('last_name')->nullable();
            $table->text('address')->after('last_name')->nullable();
            $table->date('birthday')->after('last_name')->nullable();
            $table->string('position')->after('last_name')->nullable();
            $table->string('rut_passport')->after('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_admin');
            $table->dropColumn('medical_information');
            $table->dropColumn('emergency_contact');
            $table->dropColumn('emergency_telephone');
            $table->dropColumn('telephone');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('address');
            $table->dropColumn('birthday');
            $table->dropColumn('position');
            $table->dropColumn('rut_passport');
        });
    }
}
