<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookletPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booklet_purchases', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('client_id')->unsigned()->length('10');
            $table->foreign('client_id')->references('id')->on('clients');
            
            $table->string('code');
                        
            $table->integer('user_id')->unsigned()->length('10');
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('cc_transaction');
            $table->integer('price')->unsigned();

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
        Schema::dropIfExists('booklet_purchases');
    }
}
