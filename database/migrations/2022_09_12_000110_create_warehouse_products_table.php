<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_products', function (Blueprint $table) {
            $table->id();
            // the quantity that scrapped
            $table->bigInteger('scrapped_quantity')->unsigned()->default(0);
            // the quantity that reduced when order placed
            $table->bigInteger('reduced_quantity')->unsigned();
            // the base quantity that placed at first time
            $table->bigInteger('base_quantity')->unsigned();
            $table->float('cost', 8, 2)->unsigned();
            $table->timestamp('expiry_date')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('warehouse_products');
    }
}
