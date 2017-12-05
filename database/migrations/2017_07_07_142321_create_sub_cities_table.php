<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('city_id')->unsigned()->length(10)->default(1);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->timestamps();
        });

        DB::table('sub_cities')->insert(
            [
                'name' => "Jalandhar Main"
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
        Schema::dropIfExists('sub_cities');
    }
}
