<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('slug');
            $table->string('seo_title')->nullable()->default(null);
            $table->text('announce')->nullable()->default(null);
            $table->longText('description')->nullable()->default(null);
            $table->text('seo_description')->nullable()->default(null);
            $table->text('facebook_script')->nullable()->default(null);
            $table->text('google_script')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_translation');
    }
}
