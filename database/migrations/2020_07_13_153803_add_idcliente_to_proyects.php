<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdclienteToProyects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyects', function (Blueprint $table) {
            $table->unsignedInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyects', function (Blueprint $table) {
            $table->dropForeign(['idCliente']);
            $table->dropColumn('idCliente');
        });
    }
}
