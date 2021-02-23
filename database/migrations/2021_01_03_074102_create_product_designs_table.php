<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_designs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->decimal('height', 3, 2);
            $table->decimal('width', 3, 2);
            $table->decimal('thickness', 3, 2);
            $table->string('weight');
            $table->string('color');
            $table->string('build');
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
        Schema::dropIfExists('product_designs');
    }
}
