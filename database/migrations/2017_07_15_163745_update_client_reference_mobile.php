<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientReferenceMobile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function(Blueprint $table){
            $table->integer('referral')->unsigned()->length(10)->nullable();
            $table->foreign('referral')->references('id')->on('clients');
            $table->text('device_id', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function(Blueprint $table){
            $table->dropForeign(['referral']);
            $table->dropColumn(['referral', 'device_id']);
        });
    }
}
