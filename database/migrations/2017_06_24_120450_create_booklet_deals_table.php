<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookletDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booklet_deals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("booklet_id")->unsigned()->length(10);
            $table->foreign('booklet_id')->references('id')->on('booklets');
            $table->integer("deal_id")->unsigned()->length(10);
            $table->foreign('deal_id')->references('id')->on('deals');
            $table->integer("quantity")->unsigned();
            $table->integer("daily_limit")->unsigned();

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
        Schema::dropIfExists('booklet_deals');
    }
}
