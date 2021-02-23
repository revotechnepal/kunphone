<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDisplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_displays', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->decimal('screensize', 3, 2);
            $table->string('displaytype');
            $table->string('resolution');
            $table->integer('pixeldensity');
            $table->string('protection');
            $table->string('screentobodyratio');
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
        Schema::dropIfExists('product_displays');
    }
}
