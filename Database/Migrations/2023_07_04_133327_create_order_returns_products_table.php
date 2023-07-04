<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReturnsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_returns_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_return_id');
            $table->foreign('order_return_id')->references('id')->on('order_returns')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->double('quantity');
            $table->double('price')->nullable()->default(null);
            $table->double('total')->nullable()->default(null);
            $table->double('discounts')->nullable()->default(null);
            $table->double('total_with_discounts')->nullable()->default(null);
            $table->double('vat')->nullable()->default(null);
            $table->double('grand_total')->nullable()->default(null);
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
        Schema::dropIfExists('order_returns_products');
    }
}
