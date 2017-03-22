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
            $table->integer('company_id')->unsigned()->index();
            $table->integer('worker_id')->unsigned();
            $table->integer('workplace_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('model_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('sub_category_id')->unsigned();
            $table->string('tag_rfid');
            $table->string('sku');
            $table->string('serial');
            $table->string('image');
            $table->integer('validity_time');
            $table->date('integration_date')->nullable();
            $table->date('end_service_life_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->date('disincorporation_date')->nullable();
            $table->json('custom_fields')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('workplace_id')->references('id')->on('workplaces');
            $table->nullableTimestamps();
            $table->softDeletes();

        });
        DB::statement('ALTER TABLE assets ADD location point AFTER tag_rfid');
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
