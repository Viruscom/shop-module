<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateVatCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_vat_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('vat_category_id')->unsigned();
            $table->decimal('vat',10,2)->default(0);
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vat_category_id')->references('id')->on('vat_categories')->onDelete('cascade')->onUpdate('cascade');
           
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
        Schema::dropIfExists('state_vat_categories');
    }
}
