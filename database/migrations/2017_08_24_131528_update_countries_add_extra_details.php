<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateCountriesAddExtraDetails extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('countries', function (Blueprint $table) {
                /**
                 * Locale
                 * Currency
                 * Mobile No Prefix
                 * Short Name
                 */

                $table->string('locale')->nullable();

                $table->string('currency_code')->nullable();
                $table->string('currency_name')->nullable();

                $table->string('mobile_prefix')->nullable();

                $table->string('short_name')->nullable();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('countries', function (Blueprint $table) {
                $table->dropColumn([
                    'locale',
                    'currency_code',
                    'currency_name',
                    'mobile_prefix',
                    'short_name',
                ]);
            });
        }
    }
