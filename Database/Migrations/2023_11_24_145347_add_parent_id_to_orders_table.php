<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddParentIdToOrdersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->bigInteger('parent_order_id')->unsigned()->nullable()->default(null);
                $table->foreign('parent_order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('parent_order_id');
            });
        }
    }
