<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFrontCamerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_front_cameras', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('frontcamera');
            $table->string('frontvideo');
            $table->string('frontfeatures');
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
        Schema::dropIfExists('product_front_cameras');
    }
}
