<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('country_id')->unsigned();
            $table->char('country_code', 2);
            $table->bigInteger('state_id')->unsigned();
            $table->string('state_code');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->boolean('flag')->default(1);
            $table->longText('zip_codes')->nullable('')->comment("find_in_set('searched zip',zip_codes) <> 0;");
            $table->string('wikiDataId')->nullable();
            $table->decimal('vat',10,2)->nullable()->default(null);

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('cities');
    }
}
