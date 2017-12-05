<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignBookletToCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booklets', function(Blueprint $table){
            $table->integer('city_id')->unsigned()->length(10)->default(1);
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booklets', function(Blueprint $table){
            $table->dropForeign(['city_id']);
            $table->dropColumn(['city_id']);
        });        
    }
}
