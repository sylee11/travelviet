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
<<<<<<< HEAD
            $table->string('name');
            $table->string('password');
            $table->string('email');
            $table->integer('status')->nullable();
            $table->string('fullname')->nullable();
            $table->datetime('birthday')->nullable();
=======
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->integer('status')->default(1);
            $table->date('birthday')->nullable();
>>>>>>> develop
            $table->string('address')->nullable();
            $table->integer('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken()->nullable();
<<<<<<< HEAD
            $table->integer('role')->nullable();
=======
            $table->integer('role')->default(3);
            $table->bigInteger('socials_id')->nullable(); 
>>>>>>> develop
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
