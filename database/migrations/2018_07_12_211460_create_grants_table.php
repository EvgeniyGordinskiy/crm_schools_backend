<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grant_type_id')->unsigned()->nullable();
            $table->foreign('grant_type_id')->references('id')->on('grant_types');
            $table->string('model_name');
            $table->string('event');
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
        Schema::table('grants', function(Blueprint $table) {
            $table->dropForeign(['grant_type_id']);
        });
        Schema::dropIfExists('grants');
    }
}
