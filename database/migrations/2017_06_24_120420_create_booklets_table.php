<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booklets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price')->unsigned()->length(4);
            $table->integer('validity')->unsigned()->length(3);
            $table->string('avatar')->default('jbbooklet.png');
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
        Schema::dropIfExists('booklets');
    }
}
