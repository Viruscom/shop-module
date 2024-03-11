<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalSupplierTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_supplier_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internal_supplier_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('registration_address');
            $table->timestamps();

            $table->unique(['internal_supplier_id', 'locale']);
            $table->foreign('internal_supplier_id')->references('id')->on('internal_suppliers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_supplier_translation');
    }
}
