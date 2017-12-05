<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateDealsAddPriceType extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('deals', function (Blueprint $table) {
                $table->enum('price_type', ['coupon_price', 'deal_price'])->default('coupon_price');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('deals', function (Blueprint $table) {
                $table->dropColumn(['price_type']);
            });
        }
    }
