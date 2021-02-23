<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOutgoingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_outgoings', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('ram');
            $table->string('rom');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('condition');
            $table->string('accessories');
            $table->string('color');
            $table->integer('brand_id');
            $table->string('sku')->nullable();
            $table->integer('vendor_id')->nullable();
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
        Schema::dropIfExists('product_outgoings');
    }
}
