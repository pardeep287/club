<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignStoreCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_store', function(Blueprint $table){
            $table->integer('category_id')->unsigned()->length(10);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('store_id')->unsigned()->length(10);
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_store');
    }
}
