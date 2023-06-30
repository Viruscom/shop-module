<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('eik');
            $table->string('vat_number');
            $table->string('phone');
            $table->string('email');
            $table->integer('position');
            $table->boolean('active')->default(true);
            $table->boolean('archived')->default(false);
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
        Schema::dropIfExists('internal_suppliers');
    }
}
