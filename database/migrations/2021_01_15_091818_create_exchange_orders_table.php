<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_status_id');
            $table->string('exchanging_product');
            $table->string('product1_ram');
            $table->string('product1_rom');
            $table->string('product1_price');
            $table->string('exchanged_product');
            $table->string('product2_ram');
            $table->string('product2_rom');
            $table->string('product2_price');
            $table->integer('pricediff')->nullable();
            $table->integer('delievery_address_id');
            $table->string('payment_method')->nullable();
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
        Schema::dropIfExists('exchange_orders');
    }
}
