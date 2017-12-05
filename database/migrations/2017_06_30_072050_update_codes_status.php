<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCodesStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codes', function(Blueprint $table){
            $table->dropColumn(['status']);            
        });

        Schema::table('codes', function(Blueprint $table){
            $table->enum('status', ['created', 'purchased', 'active', 'paused'])->default('created')->after('code');
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
    }
}
