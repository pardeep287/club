<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignTransactionsToBookletAndDeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function(Blueprint $table){
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
        Schema::table('transactions', function(Blueprint $table){
            $table->dropForeign(['deal_id']);
            $table->dropColumn(['deal_id']);
        });
    }
}
