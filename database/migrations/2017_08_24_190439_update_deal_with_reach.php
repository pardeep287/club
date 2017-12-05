<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateDealWithReach extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('deals', function (Blueprint $table) {
                $table->enum('reach', ['global', 'country', 'state', 'city'])->default('city');
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
                $table->dropColumn(['reach']);
            });
        }
    }
