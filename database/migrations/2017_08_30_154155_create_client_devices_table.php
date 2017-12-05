<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateClientDevicesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('client_devices', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('client_id')->unsigned()->length(10);
                $table->foreign('client_id')->references('id')->on('clients');

                $table->boolean("emulator")->default(0);

                $table->string("device_id");

                $table->text("additional");

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
            Schema::dropIfExists('client_devices');
        }
    }
