<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile')->unique()->length(16);
            $table->string('avatar')->default('jbuser.png');
            $table->enum('auth_level',['admin', 'care', 'executive'])->default('executive');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ["name" => "Android",
            "email" => "lakshayverma.clubjb@gmail.com",
            "mobile" => "9779333346",
            "password" => bcrypt('8946553$'),
            "auth_level" => "admin"],
            ["name" => "Vinod Chauhan",
            "email" => "veecee.clubjb@gmail.com",
            "mobile" => "8725044830",
            "password" => bcrypt('123456$'),
            "auth_level" => "admin"],
            ["name" => "Abhishek Aggarwal",
            "email" => "abhirscorpio@gmail.com",
            "mobile" => "8196081960",
            "password" => bcrypt('123456$'),
            "auth_level" => "admin"],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
