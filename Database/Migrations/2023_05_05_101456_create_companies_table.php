<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->string('phone');
            $table->string('street');
            $table->string('street_number');
            $table->unsignedBigInteger('country_id')->nullable()->default(null);
            $table->unsignedBigInteger('city_id')->nullable()->default(null);
            $table->string('zip_code')->nullable()->default(null);
            $table->string('company_name');
            $table->string('company_eik');
            $table->string('company_vat_eik')->nullable()->default(null);
            $table->string('company_mol');
            $table->string('company_address');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('companies');
    }
}
