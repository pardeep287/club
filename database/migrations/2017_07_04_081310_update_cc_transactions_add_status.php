<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateCCTransactionsAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_c_transactions', function(Blueprint $table){
            $table->enum('status',['pending', 'initiated' ,'success', 'failure', 'aborted', 'invalid'])->default('pending')->after('user_id');
            $table->string('tracking_id')->nullable()->after('user_id');
            $table->float('amount', 10, 2)->unsigned()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_c_transactions', function(Blueprint $table){
            $table->dropColumn(['status', 'amount', 'tracking_id']);
        });
    }
}
