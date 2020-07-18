<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProyectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_proyect', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idProducto');
            $table->unsignedInteger('idProyecto');
            $table->double('cantidad');
            $table->double('cantidadEntregada')->default(0);
            $table->timestamps();

            $table->foreign('idProducto')->references('id')->on('products');
            $table->foreign('idProyecto')->references('id')->on('proyects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_proyect');
    }
}
