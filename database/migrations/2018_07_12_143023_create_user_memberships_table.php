<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('membership_id')->unsigned();
            $table->foreign('membership_id')->references('id')->on('memberships');
            $table->primary(['user_id', 'membership_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_memberships', function(Blueprint $table) {
            $table->dropForeign(['membership_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('user_memberships');
    }
}
