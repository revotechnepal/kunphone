<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBackCamerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_back_cameras', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('backcamera');
            $table->string('backvideo');
            $table->string('backfeatures');
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
        Schema::dropIfExists('product_back_cameras');
    }
}
