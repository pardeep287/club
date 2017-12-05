<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBookletPurchasesTableAddCodeAsForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booklet_purchases', function(Blueprint $table){
            $table->integer('code_id')->unsigned()->length(10)->nullable();
            $table->foreign('code_id')->references('id')->on('codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booklet_purchases', function(Blueprint $table){
            
            $table->dropForeign(['code_id']);
            $table->dropColumn('code_id');
        });
    }
}
