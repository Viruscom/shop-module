<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('key', 255)->nullable()->default(null);
            $table->string('uid', 191)->unique();
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
            $table->longText('discounts_to_apply')->nullable()->default(null);
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('total_discounted', 10, 2)->default(0);
            $table->boolean('total_free_delivery')->default(false);
            $table->datetime('paid_at')->nullable()->default(null);
            $table->datetime('delivered_at')->nullable()->default(null);
            $table->longText('delivery_data')->nullable()->default(null);

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
        Schema::dropIfExists('orders');
    }
}
