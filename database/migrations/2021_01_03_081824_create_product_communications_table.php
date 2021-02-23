<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_communications', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('bluetooth');
            $table->string('wlan');
            $table->string('gps');
            $table->string('radio');
            $table->string('usb');
            $table->string('networksupport');
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
        Schema::dropIfExists('product_communications');
    }
}
