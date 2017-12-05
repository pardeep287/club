<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateStoresAddTopPick extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('stores', function (Blueprint $table) {
                $table->boolean('top_pick')->default(false);
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
                $table->dropColumn(['top_pick']);
            });
        }
    }
