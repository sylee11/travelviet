<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('placeid');
            $table->integer('typeplaceid');
            $table->string('name_place');
            $table->string('address_place');
            $table->integer('phone_place');
            $table->string('title_place');
            $table->string('describe_place');
            $table->string('mapping_latitude');
            $table->string('mapping_longtitue');
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
        Schema::dropIfExists('places');
    }
}
