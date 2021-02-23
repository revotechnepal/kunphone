<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIncomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_incomings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('makecalls');
            $table->string('phonescreen');
            $table->string('bodydefects');
            $table->integer('timeused');
            $table->string('duration');
            $table->string('warranty');
            $table->string('return');
            $table->string('frontcamera');
            $table->string('backcamera');
            $table->string('volumebuttons');
            $table->string('touchscreen');
            $table->string('battery');
            $table->string('volumesound');
            $table->string('colorfaded');
            $table->string('powerbutton');
            $table->string('chargingpot');
            $table->string('fullname');
            $table->string('phone');
            $table->string('otherdefects')->nullable();
            $table->integer('is_approved');
            $table->integer('is_sent')->default(0);
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
        Schema::dropIfExists('product_incomings');
    }
}
