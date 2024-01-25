<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddSentToYanakAtToOrdersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->dateTime('sent_to_yanak_at')->nullable()->default(null);
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
                $table->dropColumn('sent_to_yanak_at');
            });
        }
    }
