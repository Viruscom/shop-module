<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddProductPrintColumnToBasketProductsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('basket_products', function (Blueprint $table) {
                $table->text('product_print');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('basket_products', function (Blueprint $table) {
                $table->dropColumn('product_print');
            });
        }
    }
