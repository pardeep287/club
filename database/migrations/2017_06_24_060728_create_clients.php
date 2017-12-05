<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
        $table->increments('id');
        $table->string("name");
        $table->string('email')->nullable();
        $table->string('mobile')->unique()->length(16);
        $table->string('avatar')->default('jbclient.png');
        $table->text('address')->nullable();
        $table->string('city');
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
        Schema::dropIfExists('clients');
    }
}
