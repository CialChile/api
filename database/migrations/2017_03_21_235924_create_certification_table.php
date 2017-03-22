<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->integer('institute_id')->unsigned();
            $table->integer('certification_type_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('sku');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('validity_time');
            $table->boolean('validity')->default(0);
            $table->foreign('institute_id')->references('id')->on('institutes');
            $table->foreign('certification_type_id')->references('id')->on('certification_types');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->nullableTimestamps();
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
        Schema::dropIfExists('certifications');
    }
}
