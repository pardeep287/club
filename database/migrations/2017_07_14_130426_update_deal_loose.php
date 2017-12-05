<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDealLoose extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('deals', function(Blueprint $table){
            $table->integer('city_id')->unsigned()->length(10)->default(1)->after('active');
            $table->foreign('city_id')->references('id')->on('cities');

            $table->integer('sub_city_id')->unsigned()->length(10)->nullable()->after('city_id');
            $table->foreign('sub_city_id')->references('id')->on('sub_cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function(Blueprint $table){
            $table->dropForeign(['city_id']);
            $table->dropForeign(['sub_city_id']);
            $table->dropColumn(['city_id', 'sub_city_id']);
        });
    }
}
