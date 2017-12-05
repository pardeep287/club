<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateBonusDealCodesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('bonus_deal_codes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer("bonuscode_id")->unsigned()->length(10);
                $table->foreign('bonuscode_id')->references('id')->on('bonus_deals');
                $table->string("code");

                $table->integer("used_by")->unsigned()->length(10)->nullable();
                $table->foreign('used_by')->references('id')->on('clients');

                $table->boolean('status')->default(true);

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
            Schema::dropIfExists('bonus_deal_codes');
        }
    }
