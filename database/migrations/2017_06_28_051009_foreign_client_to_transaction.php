<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignClientToTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function(Blueprint $table){
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
            $table->integer('client_code_id')->unsigned()->length(10);
            $table->foreign('client_code_id')->references('id')->on('client_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('transactions', function(Blueprint $table){
            $table->dropForeign(['client_code_id']);
            $table->dropColumn('client_code_id');
        });
    }
}
