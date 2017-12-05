<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateStoresPreferredTrusted extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('stores', function (Blueprint $table) {
                $table->boolean('preferred')->default(false);
                $table->boolean('trusted')->default(false);
                $table->string('membership')->default('silver');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('stores', function (Blueprint $table) {
                $table->dropColumn([
                    'preferred',
                    'trusted',
                    'membership',
                ]);
            });
        }
    }
