<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdboxesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_adboxes_translation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ad_box_product_id')->unsigned();
            $table->foreign('ad_box_product_id')->references('id')->on('product_adboxes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('locale')->index();
            $table->boolean('visible')->default(true);
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
        Schema::dropIfExists('product_adboxes_translation');
    }
}
