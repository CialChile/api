<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku');
            $table->string('tag_rfid');
            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->integer('model_id')->unsigned();
            $table->foreign('model_id')->references('id')->on('model');
            $table->string('serial');
            $table->string('image');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category');
            $table->integer('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_category');
            $table->integer('validity_time');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status');
            $table->date('integration_date');
            $table->date('end_service_life_date');
            $table->date('warranty_date');
            $table->date('disincorporation_date');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('worker_id')->unsigned();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->integer('workplace_id')->unsigned();
            $table->foreign('workplace_id')->references('id')->on('workplace');
            $table->json('fields_json');
            $table->timestamps();
            $table->softDeletes();

        });
        DB::statement('ALTER TABLE assets ADD location point');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
