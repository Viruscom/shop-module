<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class OrderProductsCollectionPivotTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('order_products_collection_pivot', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_product_id');
                $table->integer('product_id');
                $table->integer('main_product_id');
                $table->decimal('price', 10, 2);
                $table->decimal('quantity', 10, 2)->default(0.00);
                $table->decimal('total', 10, 2)->default(0.00);
                $table->text('product_print');
                $table->foreign('order_product_id')->references('id')->on('order_products')->onDelete('cascade')->onUpdate('cascade');
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
            Schema::dropIfExists('order_products_collection_pivot');
        }
    }
