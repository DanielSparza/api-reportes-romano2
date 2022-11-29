<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Servicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('clave_servicio');
            $table->bigInteger('fk_paquete')->unsigned();
            $table->bigInteger('fk_cliente')->unsigned();
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->string('foto_fachada', 300)->nullable();
            $table->timestamps();
            $table->foreign('fk_paquete')->references('clave_paquete')->on('paquetesinternet');
            $table->foreign('fk_cliente')->references('fk_clave_persona')->on('clientes');
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
        Schema::dropIfExists('servicios');
    }
}
