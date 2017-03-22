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
        Schema::create('certification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku');
            $table->string('name');
            $table->string('description');
            $table->integer('validity_time');
            $table->boolean('validity');
            $table->integer('institute_id')->unsigned();
            $table->foreign('institute_id')->references('id')->on('institute');
            $table->integer('type_certification_id')->unsigned();
            $table->foreign('type_certification_id')->references('id')->on('type_certification');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
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
        Schema::dropIfExists('certification');
    }
}
