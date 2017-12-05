<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_coupons', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('deal_id')->unsigned()->length(10);
            $table->foreign('deal_id')->references('id')->on('deals');

            $table->string('code');

            $table->enum('status',['created', 'purchased','active', 'paused'])->default('created');
            
            $table->enum('method',['imported','generated']);
            $table->integer('user_id')->unsigned()->length(10);
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('begin');
            $table->date('end');

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
        Schema::dropIfExists('deal_coupons');
    }
}
