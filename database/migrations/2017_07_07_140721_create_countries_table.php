<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('countries')->insert([
            'name' => 'India'
        ]);

        Schema::table('states', function(Blueprint $table){
            $table->integer('country_id')->unsigned()->length(10)->default(1);
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('states', function(BluePrint $table){
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });
        Schema::dropIfExists('countries');
    }
}
