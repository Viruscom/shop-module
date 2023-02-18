<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', static function(Blueprint $table)
        {
            $table->id();

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('position');
            $table->integer('creator_user_id');
            $table->integer('units_in_stock')->default(1);
            $table->decimal('supplier_delivery_price', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('barcode', 191)->nullable();
            $table->string('ean_code', 191)->nullable();
            $table->string('measure_unit', 191)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_promo')->default(false);
            $table->string('width', 191)->nullable();
            $table->string('height', 191)->nullable();
            $table->string('length', 191)->nullable();
            $table->string('weight', 191)->nullable();
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
        Schema::drop('products');
    }

}
