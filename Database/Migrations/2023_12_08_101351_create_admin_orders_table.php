<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateAdminOrdersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('admin_orders', function (Blueprint $table) {
                $table->id();
                $table->string('admin_basket_key', 255)->nullable()->default(null);
                $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
                $table->foreign('user_id')->references('id')->on('shop_registered_users')->onDelete('cascade')->onUpdate('cascade');
                $table->string('email');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone');
                $table->text('street');
                $table->string('street_number');
                $table->bigInteger('country_id')->unsigned();
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
                $table->bigInteger('city_id')->unsigned();
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
                $table->string('zip_code');
                $table->boolean('invoice_required')->default(false);
                $table->text('company_name')->nullable()->default(null);
                $table->string('company_eik')->nullable()->default(null);
                $table->string('company_vat_eik')->nullable()->default(null);
                $table->string('company_mol')->nullable()->default(null);
                $table->text('company_address')->nullable()->default(null);
                $table->bigInteger('payment_id')->unsigned();
                $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade')->onUpdate('cascade');
                $table->bigInteger('delivery_id')->unsigned();
                $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade')->onUpdate('cascade');
                $table->boolean('with_utensils')->default(false);
                $table->text('comment')->nullable()->default(null);
                $table->string('entrance')->nullable();
                $table->integer('floor')->nullable();
                $table->string('apartment')->nullable();
                $table->string('bell_name')->nullable();

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
            Schema::dropIfExists('admin_orders');
        }
    }
