<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoresMultilineAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function(Blueprint $table){
            $table->string('address_1')->default('.')->after('avatar');
            $table->string('address_2')->nullable()->after('avatar');
            $table->string('address_3')->nullable()->after('avatar');
            $table->string('pincode')->length(25)->after('avatar');
            $table->float('latitude', 10, 6)->default('31.3245')->after('avatar');
            $table->float('longitude', 10, 6)->default('75.5812')->after('avatar');
            $table->boolean('active')->after('avatar');
            $table->text('terms')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function(Blueprint $table){
            $table->dropColumn([
                'address_1',
                'address_2',
                'address_3',
                'pincode',
                'latitude',
                'longitude',
                'active',
                'terms'
                ]);
        });
    }
}
