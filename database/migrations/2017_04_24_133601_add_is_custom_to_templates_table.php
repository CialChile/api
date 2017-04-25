<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCustomToTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign('templates_template_type_id_foreign');
            $table->boolean('is_custom')->default(false)->after('execution_estimated_time');
            $table->dropColumn('template_type_id');
        });

        Schema::dropIfExists('template_types');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('template_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->string('name');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('is_custom');
            $table->integer('template_type_id')->unsigned()->nullable()->after('company_id');
            $table->foreign('template_type_id')->references('id')->on('template_types');

        });
    }
}
