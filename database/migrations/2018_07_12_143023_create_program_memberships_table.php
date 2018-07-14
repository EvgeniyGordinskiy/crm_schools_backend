<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_memberships', function (Blueprint $table) {
            $table->integer('program_id')->unsigned();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->integer('membership_id')->unsigned();
            $table->foreign('membership_id')->references('id')->on('memberships');
            $table->primary(['program_id', 'membership_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_memberships', function(Blueprint $table) {
            $table->dropForeign(['membership_id']);
            $table->dropForeign(['program_id']);
        });
        Schema::dropIfExists('program_memberships');
    }
}
