<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->integer('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->integer('payment_settings_id')->unsigned()->nullable();
            $table->foreign('payment_settings_id')->references('id')->on('payment_settings');
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->tinyInteger('registrationComplete')->default(0);
            $table->tinyInteger('phoneNumberVerified')->default(0);
            $table->tinyInteger('emailVerified')->default(0);
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
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['payment_settings_id']);
        });
        Schema::dropIfExists('users');
    }
}
