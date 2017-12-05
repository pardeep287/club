<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignDealCategorySubCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_deal', function(Blueprint $table){
            $table->integer('category_id')->unsigned()->length(10);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('deal_id')->unsigned()->length(10);
            $table->foreign('deal_id')->references('id')->on('deals');
        });
        Schema::create('deal_sub_category', function(Blueprint $table){
            $table->integer('sub_category_id')->unsigned()->length(10);
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->integer('deal_id')->unsigned()->length(10);
            $table->foreign('deal_id')->references('id')->on('deals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_deal');
        Schema::dropIfExists('deal_sub_category');
    }
}
