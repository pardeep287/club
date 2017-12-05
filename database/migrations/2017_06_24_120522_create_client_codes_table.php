<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("client_id")->unsigned()->length(10);
            $table->foreign('client_id')->references('id')->on('clients');
            $table->integer("code_id")->unsigned()->length(10);
            $table->foreign('code_id')->references('id')->on('codes');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_codes');
    }
}
