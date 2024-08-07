<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateShopRegUserShipmentAddressesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('shop_reg_user_shipment_addresses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('country_id');
                $table->unsignedBigInteger('state_id');
                $table->unsignedBigInteger('city_id');
                $table->string('zip_code');
                $table->string('name');
                $table->string('street');
                $table->string('street_number');
                $table->boolean('is_default')->default(false);
                $table->boolean('is_deleted')->default(false);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('shop_registered_users')->onDelete('cascade');
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('shop_reg_user_shipment_addresses');
        }
    }
