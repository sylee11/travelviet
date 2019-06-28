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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('password');
            $table->string('email');
            $table->integer('status')->nullable($value = true)  ;
            $table->string('fullname')->nullable($value = true) ;
            $table->datetime('birthday')->nullable($value = true)   ;
            $table->string('address')->nullable($value = true)  ;
            $table->integer('phone')->nullable($value = true)   ;
            $table->string('avatar')->nullable($value = true)   ;
            $table->rememberToken()->nullable($value = true)   ;;
            $table->integer('role')->nullable($value = true)    ;
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
        Schema::dropIfExists('users');
    }
}
