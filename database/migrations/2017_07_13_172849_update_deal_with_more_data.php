<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDealWithMoreData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('deals', function (Blueprint $table) {
            $table->text('club_terms')->nullable()->after('terms');
            
            $table->boolean('active')->default(true)->after('title');

            $table->enum('kind', ['booklet', 'loose'])->default('booklet')->after('type');
            
            $table->string('call_to')->length('20')->default('+918196081960');
            $table->text('call_to_message')->nullable()->after('call_to');

            $table->integer('person_limit')->unsigned()->length(4)->default(2)->after('call_to_message');

            $table->integer('handling_fee')->default(0)->after('price');
            $table->enum('discount_type', ['direct', 'percentage'])->default('direct')->after('price');
            $table->integer('discount_value')->default(0)->after('discount_type');

            $table->integer('coin_use')->unsigned()->length(4)->default(10)->after('price');
            $table->integer('coin_get')->unsigned()->length(4)->default(10)->after('coin_use');

            $table->string('meta_title')->default('Club JB Deals and More');
            $table->text('meta_description')->nullable();

        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function(Blueprint $table){
            $table->dropColumn([
                'club_terms',
                'active',
                'kind',
                'call_to',
                'call_to_message',
                'person_limit',
                'handling_fee',
                'discount_type',
                'discount_value',
                'coin_use',
                'coin_get',
                'meta_title',
                'meta_description'
            ]);
        });
    }
}
