<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });
        DB::table("default_values")->insert([
            ['key' => 'jbTerms',
            'value' => "JB Terms"],
            ['key' => 'dealTerms',
            'value' => "JB Deal Terms"],
            ['key' => 'dealdescription',
            'value' => "JB Deal Descriptions"],
            ['key' => 'jbcare',
            'value' => '8196081960'],
            ['key' => 'jbcare_jalandhar',
            'value' => '8196081960'],
            ['key' => 'about',
            'value' => 'About Club JB'],
            ['key' => 'comingsoon',
            'value' => 'We are preparing something new, Stay Tunned...'],
            ['key' => 'share',
            'value' => 'Share JB'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_values');
    }
}
