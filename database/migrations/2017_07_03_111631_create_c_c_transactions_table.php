<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCCTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_c_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('order_type',['booklet','coupon']);

            $table->integer('client_id')->unsigned()->length('10');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('user_id')->unsigned()->length(10);
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('note');

            $table->timestamps();
        });

        Schema::table('booklet_purchases', function(Blueprint $table){
            $table->integer('cc_transaction_id')->unsigned()->length(10)->after('user_id')->nullable();
            $table->foreign('cc_transaction_id')->references('id')->on('c_c_transactions');
        });

        Schema::table('transactions', function(Blueprint $table){            
            $table->integer('cc_transaction_id')->unsigned()->length(10)->after('user_id')->nullable();
            $table->foreign('cc_transaction_id')->references('id')->on('c_c_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_c_transactions');
    }
}