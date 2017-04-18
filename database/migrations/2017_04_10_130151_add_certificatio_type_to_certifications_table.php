<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCertificatioTypeToCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropForeign('certifications_certification_type_id_foreign');
            $table->dropColumn('certification_type_id');
            $table->tinyInteger('type')->after('validity')->comment('0:Activo,1:trabajador,2:ambos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->integer('certification_type_id')->unsigned()->after('institute_id');

        });
    }
}
