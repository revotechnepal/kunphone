<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_confirms', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('incomingproduct_id');
            $table->string('product1_ram');
            $table->string('product1_rom');
            $table->string('product1_price');
            $table->integer('outgoingproduct_id');
            $table->string('product2_ram');
            $table->string('product2_rom');
            $table->string('product2_price');
            $table->string('pricediff');
            $table->string('vendor');
            $table->string('exchangecode');
            $table->string('frontimage');
            $table->string('backimage');
            $table->integer('is_processsing')->nullable();
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
        Schema::dropIfExists('exchange_confirms');
    }
}
