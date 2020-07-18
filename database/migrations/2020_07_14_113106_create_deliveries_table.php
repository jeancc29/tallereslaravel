<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->timestamps();

            $table->unsignedInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('customers');

            $table->unsignedInteger('idProyecto');
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
        Schema::dropIfExists('deliveries');
    }
}
