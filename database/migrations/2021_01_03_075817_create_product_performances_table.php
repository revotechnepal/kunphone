<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_performances', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('gpu');
            $table->string('os');
            $table->string('chipsetgp');
            $table->string('cpu');
            $table->string('sensors');
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
        Schema::dropIfExists('product_performances');
    }
}
