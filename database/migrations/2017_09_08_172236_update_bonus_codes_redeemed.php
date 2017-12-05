<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateBonusCodesRedeemed extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('bonus_deal_codes', function (Blueprint $table) {
                $table->boolean('redeemed')->default(false);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('bonus_deal_codes', function (Blueprint $table) {
                $table->dropColumn(['redeemed']);
            });
        }
    }
