<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('category_id')->unsigned()->length(10);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
        });


        DB::table('sub_categories')->insert(
            [
                ['name' => "General Subcategory", 'description' => "General coupons by Club JB", 'category_id' => 1],
                ['name' => "Movies Subcategory", 'description' => "Movie coupons by Club JB", 'category_id' => 2],
                ['name' => "Food Subcategory", 'description' => "Food coupons by Club JB", 'category_id' => 3],
                ['name' => "Drinks Subcategory", 'description' => "Drink coupons by Club JB", 'category_id' => 4],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
