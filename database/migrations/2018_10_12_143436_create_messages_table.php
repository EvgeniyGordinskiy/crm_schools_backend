<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('from')->unsigned()->nullable();
            $table->foreign('from')->references('id')->on('users')->onDelete('set null');
            $table->integer('to')->unsigned()->nullable();
            $table->foreign('to')->references('id')->on('users')->onDelete('set null');
            $table->integer('permission_type_id')->unsigned();
            $table->foreign('permission_type_id')->references('id')->on('permission_types');
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
        Schema::table('messages', function(Blueprint $table) {
            $table->dropForeign(['permission_type_id']);
            $table->dropForeign(['to']);
            $table->dropForeign(['from']);
        });
        Schema::dropIfExists('messages');
    }
}
