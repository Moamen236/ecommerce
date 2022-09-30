<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name_en')->nullable();
            $table->text('name_ar')->nullable();
            $table->text('short_description_en')->nullable();
            $table->text('short_description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('slug')->nullable();
            $table->string('sku')->nullable();
            $table->float('price', 8, 2)->unsigned();
            $table->float('final_price', 8, 2)->unsigned();
            $table->bigInteger('total_quantity')->unsigned()->default(0);
            $table->integer('expiry_alarm_before')->unsigned();
            $table->boolean('free_shipping')->default(0);
            $table->boolean('allow_review')->default(1);
            $table->text('image_url')->nullable();
            $table->boolean('active')->default(1);
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
