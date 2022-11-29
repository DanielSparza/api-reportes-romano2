<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Clientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('fk_clave_persona');
            $table->string('direccion', 100);
            $table->string('nexterior', 10);
            $table->string('ninterior', 10)->nullable();
            $table->string('colonia', 50)->nullable();
            $table->bigInteger('fk_comunidad')->unsigned();
            $table->string('estado', 30);
            $table->string('telefono_fijo', 50)->nullable();
            $table->timestamps();
            $table->foreign('fk_clave_persona')->references('clave_persona')->on('personas');
            $table->foreign('fk_comunidad')->references('clave_comunidad')->on('comunidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('clientes');
    }
}
