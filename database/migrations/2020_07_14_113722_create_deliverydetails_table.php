<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverydetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('detalles');
            $table->double('cantidad');
            $table->timestamps();

            $table->unsignedInteger('idEntrega');
            $table->foreign('idEntrega')->references('id')->on('deliveries');

            $table->unsignedInteger('idProducto');
            $table->foreign('idProducto')->references('id')->on('products');

            $table->unsignedInteger('idUnidad');
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
        Schema::dropIfExists('deliverydetails');
    }
}
