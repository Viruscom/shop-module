<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateShopRegisteredUsersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('shop_registered_users', function (Blueprint $table) {
                $table->id()->unique();
                $table->unsignedBigInteger('client_group_id')->default(0);
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone');
                $table->date('birthday')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->integer('active')->default(0);
                $table->integer('newsletter_subscribed')->default(0);
                $table->rememberToken();
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
            Schema::dropIfExists('shop_registered_users');
        }
    }
