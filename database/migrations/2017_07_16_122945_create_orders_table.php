<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('deal_id')->unsigned()->length(10);
            $table->foreign('deal_id')->references('id')->on('deals');
            $table->integer('client_id')->unsigned()->length(10);
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('booklet_id')->unsigned()->length(10)->nullable();
            $table->foreign('booklet_id')->references('id')->on('booklets');
            $table->integer('client_code_id')->unsigned()->length(10)->nullable();
            $table->foreign('client_code_id')->references('id')->on('client_codes');
            
            $table->integer('user_id')->unsigned()->length(10)->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->text('remarks')->nullable();
            
            $table->enum('status',['pending', 'initiated' ,'success', 'failure', 'aborted', 'invalid', 'nocoupons'])->default('pending');

            $table->enum('redeem_mode',['online','offline']);
            $table->integer('cc_transaction_id')->unsigned()->length(10)->nullable();
            $table->foreign('cc_transaction_id')->references('id')->on('c_c_transactions');
                        
            $table->integer('deal_coupon_id')->unsigned()->length(10)->nullable();
            $table->foreign('deal_coupon_id')->references('id')->on('deal_coupons');

            
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
        Schema::dropIfExists('orders');
    }
}
