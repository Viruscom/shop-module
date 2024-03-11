<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateBasketsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('baskets', function (Blueprint $table) {
                $table->id();

                $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
                $table->foreign('user_id')->references('id')->on('shop_registered_users')->onDelete('cascade')->onUpdate('cascade');
                $table->string('key', 255)->nullable()->default(null);

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
            Schema::dropIfExists('baskets');
        }
    }
