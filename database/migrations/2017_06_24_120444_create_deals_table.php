<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");

            $table->integer("store_id")->unsigned()->length(10);
            $table->foreign('store_id')->references('id')->on('stores');

            $table->string('avatar')->default('jbdeal.png');

            $table->enum('type',['normal','explicit'])->default('normal');
            
            $table->date("begin");
            $table->date("end");

            //Used in case Deal type is EXPLICIT
            $table->integer("days")->unsigned()->length(4)->nullable();
            
            $table->text("description")->nullable();
            $table->text("terms")->nullable();
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
        Schema::dropIfExists('deals');
    }
}
