<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        DB::table('categories')->insert(
            [
                ['name' => "General", 'description' => "General coupons by Club JB"],
                ['name' => "Movies", 'description' => "Movie coupons by Club JB"],
                ['name' => "Food", 'description' => "Food coupons by Club JB"],
                ['name' => "Drinks", 'description' => "Drink coupons by Club JB"],
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
        Schema::dropIfExists('categories');
    }
}