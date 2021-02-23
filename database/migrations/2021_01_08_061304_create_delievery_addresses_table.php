<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelieveryAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delievery_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('address');
            $table->string('tole');
            $table->string('town');
            $table->string('postcode');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->integer('user_id');
            $table->integer('is_default')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('delievery_addresses');
    }
}
