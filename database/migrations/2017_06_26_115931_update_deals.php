<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function(Blueprint $table){
            $table->integer('max_quantity')->unsigned()->default(5);
            $table->integer('max_daily_limit')->unsigned()->default(2);
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
            $table->dropColumn(['max_quantity', 'max_daily_limit']);
        });
    }
}
