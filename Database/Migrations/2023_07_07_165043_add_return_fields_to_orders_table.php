<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('returned_amount')->nullable();
            $table->date('date_of_return')->nullable();
            $table->string('type_of_return')->nullable();
            $table->text('return_comment')->nullable();
            $table->string('vr_number')->nullable()->comment('Virtual receipt number');
            $table->string('vr_trans_number')->nullable()->comment('Virtual receipt transaction number');
            $table->date('vr_date')->nullable()->comment('Virtual receipt date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('returned_amount');
            $table->dropColumn('date_of_return');
            $table->dropColumn('type_of_return');
            $table->dropColumn('return_comment');
            $table->dropColumn('vr_number');
            $table->dropColumn('vr_trans_number');
            $table->dropColumn('vr_date');
        });
    }
}
