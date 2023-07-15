<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCollectionsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_collections_pivot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('collection_id')->unsigned();
            $table->foreign('collection_id')->references('id')->on('product_collections')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('main_product_id')->index();
            $table->integer('additional_product_id');
            $table->double('price');
            $table->double('discount');
            $table->double('price_with_discount');

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
        Schema::dropIfExists('product_collections_pivot');
    }
}
