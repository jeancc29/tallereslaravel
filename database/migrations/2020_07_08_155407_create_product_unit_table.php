<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_unit', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idProducto');
            $table->unsignedInteger('idUnidad');
            $table->boolean('pordefecto')->default(0);
            $table->timestamps();

            $table->foreign('idProducto')->references('id')->on('products');
            $table->foreign('idUnidad')->references('id')->on('units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_unit');
    }
}
